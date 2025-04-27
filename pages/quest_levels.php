<?php
session_start();
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT xp FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$xp = $user['xp'] ?? 0;
$level = floor($xp / 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quest Levels</title>
  <link rel="stylesheet" href="../assets/style/quest-levels.css">
</head>
<body>
  <h1 class="title">🧩 QALAM QUEST LEVELS</h1>

  <div class="levels-container">
    <div class="level-card <?= $level >= 1 ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/spring.png" alt="Spring">
      <h3>Level 1 — Көктем</h3>
      <?= $level >= 1 ? '<a href="level1_map.php" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>

    <div class="level-card <?= $level >= 2 ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/summer.png" alt="Summer">
      <h3>Level 2 — Жаз</h3>
      <?= $level >= 2 ? '<a href="tasks.php?level=2" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>

    <div class="level-card <?= $level >= 3 ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/fall.png" alt="Fall">
      <h3>Level 3 — Күз</h3>
      <?= $level >= 3 ? '<a href="tasks.php?level=3" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>

    <div class="level-card <?= $level >= 4 ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/winter.png" alt="Winter">
      <h3>Level 4 — Қыс</h3>
      <?= $level >= 4 ? '<a href="tasks.php?level=4" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>
  </div>
  <!-- Qalam Bot -->
  <div class="qalam-bot">
    <div class="bot-speech" id="bot-speech">
      Code Quest дайын – тек сені күтіп тұр!
    </div>
    <img src="../assets/images/bot/Merlin.png" alt="Qalam Bot">
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
