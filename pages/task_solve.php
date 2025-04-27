<?php
session_start();
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("No task ID provided.");
}

$task_id = intval($_GET['id']);
$query = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    die("Task not found.");
}

$result_msg = "";
$email = $_SESSION['email'];

$check = $conn->prepare("SELECT * FROM user_task WHERE email = ? AND task_id = ?");
$check->bind_param("si", $email, $task_id);
$check->execute();
$already_done = $check->get_result()->num_rows > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_code = $_POST['code'];
    $temp_file = tempnam(sys_get_temp_dir(), 'qalam_') . '.py';
    file_put_contents($temp_file, $user_code);

    $output = [];
    $status = 0;
    exec("python " . escapeshellarg($temp_file), $output, $status);
    unlink($temp_file);

    $final_output = trim(implode("\n", $output));
    var_dump($final_output);


    $stmt = $conn->prepare("SELECT expected_output FROM task_outputs WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $results = $stmt->get_result();

    $accepted_outputs = [];
    while ($row = $results->fetch_assoc()) {
        $accepted_outputs[] = trim($row['expected_output']);
    }

    $is_correct = in_array($final_output, $accepted_outputs);

    if ($is_correct) {
        if (!$already_done) {
            $result_msg = "<span style='color:lime;'>✅ Дұрыс! Сіз XP алдыңыз!</span>";

            $xp = $task['xp_reward'];
            $coins = $task['coin_reward'];

            $update = $conn->prepare("UPDATE users SET xp = xp + ?, coins = coins + ? WHERE email = ?");
            $update->bind_param("iis", $xp, $coins, $email);
            $update->execute();

            $log = $conn->prepare("INSERT INTO user_task (email, task_id) VALUES (?, ?)");
            $log->bind_param("si", $email, $task_id);
            $log->execute();
        } else {
            $result_msg = "<span style='color:orange;'>⚠️ Тапсырма бұрын орындалған! XP берілмейді.</span>";
        }
    } else {
        $result_msg = "<span style='color:red;'>❌ Қате жауап! Шығарылған нәтиже: $final_output</span>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Qalam Solve Task</title>
  <link rel="stylesheet" href="../assets/style/solve.css">
</head>
<body>
  <h1><?= htmlspecialchars($task['title']) ?></h1>
  <p><?= nl2br(htmlspecialchars($task['description'])) ?></p>

  <form method="POST">
    <textarea name="code" rows="10" cols="60" placeholder="<?php echo 'print("Hello World");'; ?>"></textarea><br><br>
    <button type="submit">Тексеру ✅</button>
  </form>

  <div><?= $result_msg ?></div>
</body>
</html>
