<?php
session_start();
require_once '../includes/config.php';

// Егер тіркелмеген болса — логин бетіне бағытта
if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginregister.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT access_level, has_paid FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Төлем жасалмаса → QR бетіне жібер
if (!$user || !$user['has_paid']) {
    header("Location: pay.php");
    exit;
}

// Сабақтар тізімі
$access_level = $user['access_level'];
$tasks = [];

if ($access_level === 'junior') {
    $stmt = $conn->query("SELECT * FROM tasks WHERE level = 'junior'");
} elseif ($access_level === 'middle') {
    $stmt = $conn->query("SELECT * FROM tasks WHERE level IN ('junior', 'middle')");
} elseif ($access_level === 'full') {
    $stmt = $conn->query("SELECT * FROM tasks");
}
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Qalam - Тапсырмалар</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>
    <h1>Тапсырмалар</h1>
    <p>Сенің рұқсатың: <strong><?= $access_level ?></strong></p>

    <div class="task-list">
        <?php foreach ($tasks as $task): ?>
            <div class="task-card">
                <h3><?= htmlspecialchars($task['title']) ?></h3>
                <p><?= htmlspecialchars($task['description']) ?></p>
                <a href="solve_task.php?id=<?= $task['id'] ?>">Шешу</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
