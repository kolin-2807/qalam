<?php
session_start();
require '../config.php'; // config жолы өзіңде қалай болса, солай өзгерте сал

// Егер кірмеген болса, артқа жібереді
echo (!isset($_SESSION['email'])) ? header("Location: ../index.php") : "";

// Тапсырмалар базадан
$sql = "SELECT * FROM tasks ORDER BY id ASC";
$result = $conn->query($sql);
$level = isset($_GET['level']) ? intval($_GET['level']) : 1;
$stmt = $conn->prepare("SELECT * FROM tasks WHERE level = ?");
$stmt->bind_param("i", $level);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Qalam Tasks</title>
  <link rel="stylesheet" href="../assets/tasks.css"> <!-- Бұл жерде жеке CSS-файл болады -->
</head>
<body>
  <h1 class="title"> LEVEL 1: BEGINNER QUESTS</h1>
  <div class="task-container">
    <?php while($task = $result->fetch_assoc()): ?>
      <div class="task-card">
        <h2><?= htmlspecialchars($task['title']) ?></h2>
        <p><?= htmlspecialchars($task['description']) ?></p>
        <div class="task-meta">
          <span class="difficulty <?= $task['difficulty'] ?>"><?= ucfirst($task['difficulty']) ?></span>
          <span>💥 <?= $task['xp_reward'] ?> XP</span>
          <span>🪙 <?= $task['coin_reward'] ?> coins</span>
        </div>
        <a href="task_solve.php?id=<?= $task['id'] ?>" class="solve-btn">Solve</a>
      </div>
    <?php endwhile; ?>
  </div>

   <!-- Qalam Bot -->
   <div class="qalam-bot">
    <div class="bot-speech" id="bot-speech">
      Code Quest дайын – тек сені күтіп тұр!
    </div>
    <img src="../assets/bot/Merlin.png" alt="Qalam Bot">
  </div>

  <script>
    const botPhrases = [
      "Қош келдің, батыр Қажы!",
      "Code Quest дайын – тек сені күтіп тұр!",
      "Сенде бүгін күшті күн болады!",
      "XP жинау — батырлар ісі!",
      "Сабақ шешіп көр – бір бейдж күтіп тұр!"
    ];

    document.addEventListener("DOMContentLoaded", function() {
      const message = botPhrases[Math.floor(Math.random() * botPhrases.length)];
      document.getElementById("bot-speech").textContent = message;
    });
  </script>
</body>
</html>
