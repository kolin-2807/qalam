<?php
session_start();
require '../config.php'; // Базамен байланыс

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];

// Пайдаланушыны базадан алу
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$name = htmlspecialchars($user['name'] ?? 'Player');
$xp = $user['xp'] ?? 0;
$coins = $user['coins'] ?? 0;
?>


<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qalam - 2D ретро платформа</title>
    <link rel="stylesheet" href="../assets/style-user.css">
</head>
<body>

<div class="header">
    <div class="logo">
        Qalam 
        <img src="../assets/navigationimages/LOGOTYPE-QALAM.png" alt="Logo">
    </div>

    <div class="nav">
        <a href="../pages/quest_levels.php"><img src="../assets/navigationimages/SvitokQALAM.png" alt="Courses"></a>
        <a href="#"><img src="../assets/navigationimages/KubokQALAM.png" alt="League"></a>
        <a href="#"><img src="../assets/navigationimages/homeQALAM.png" alt="Home"></a>
        <a href="#"><img src="../assets/navigationimages/MozgQALAM.png" alt="Clubs"></a>
        <a href="#"><img src="../assets/navigationimages/CherepQALAM.png" alt="Subs"></a>
    </div>

    <div class="profile">
        <a href="profile.php">👤 <?= $name ?></a> 
        | ⭐ <?= $xp ?> XP 
        | 💰 <?= $coins ?>
    </div>
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
  "Сабақ шешіп көр – бір бейдж күтіп тұр!",
];

document.addEventListener("DOMContentLoaded", function() {
  const message = botPhrases[Math.floor(Math.random() * botPhrases.length)];
  document.getElementById("bot-speech").textContent = message;
});
</script>


</body>
</html>
