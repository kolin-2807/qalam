<?php
// includes/header.php

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
    <link rel="stylesheet" href="../assets/style/header_css.css">
</head>
<body>
<div class="header">
  <div class="burger-menu" style="margin-right: 14px">
    <div class="burger-icon" onclick="toggleBurgerMenu()">☰</div>
    <div class="burger-content" id="burger-content">
      <a href="../pages/quest_levels.php"><img src="../assets/images/navigationimages/SvitokQALAM.png" alt="Courses">Courses</a>
      <a href="Kubok.php"><img src="../assets/images/navigationimages/KubokQALAM.png" alt="League">League</a>
      <a href="#"><img src="../assets/images/navigationimages/homeQALAM.png" alt="Home">Home</a>
      <a href="#"><img src="../assets/images/navigationimages/MozgQALAM.png" alt="Clubs">Q-hub</a>
      <a href="#"><img src="../assets/images/navigationimages/CherepQALAM.png" alt="Subs">Plans</a>
      <!-- 🔔 Қоңырау иконкасы -->
      <div class="notification-icon">
        <img src="../assets/images/notificationqalam.png" alt="Notifications">
      </div>
    </div>
  </div>

  <div class="logo" style="margin-right: 1032px;">
    Qalam 
    <img src="../assets/images/navigationimages/LOGOTYPE-QALAM.png" alt="Logo">
  </div>

  <div class="profile">
    <a href="profile.php"> <img src='../assets/images/profileqalamp.png' style='width:18px; height:18px;'> <?= $name ?></a> 
     <img src='../assets/images/xpqalam.png' style='width:18px; height:18px;'> <?= $xp ?>  
     <img src='../assets/images/coinqalam.png' style='width:18px; height:18px;'> <?= $coins ?>
  </div>
</div>

<script>
function toggleBurgerMenu() {
  const content = document.getElementById('burger-content');
  if (content.style.display === 'flex') {
    content.style.display = 'none';
  } else {
    content.style.display = 'flex';
  }
}
</script>
