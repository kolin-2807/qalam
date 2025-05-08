<?php
// includes/header.php

session_start();
require '../config.php'; // Базамен байланыс

$email = $_SESSION['email'] ?? null;
$user = [];
$name = 'Қонақ';
$xp = 0;
$coins = 0;

if ($email) {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $name = htmlspecialchars($user['name'] ?? 'Player');
    $xp = $user['xp'] ?? 0;
    $coins = $user['coins'] ?? 0;
}
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
      <a href="../pages/Kubok.php"><img src="../assets/images/navigationimages/KubokQALAM.png" alt="League">League</a>
      <a href="../pages/user_page.php"><img src="../assets/images/navigationimages/homeQALAM.png" alt="Home">Home</a>
      <a href="/Qalam/qalamchat/Qalamchat.php"><img src="../assets/images/navigationimages/MozgQALAM.png" alt="Clubs">Q-hub</a>
      <a href="../pages/Plans.php"><img src="../assets/images/navigationimages/CherepQALAM.png" alt="Subs">Plans</a>
      <!-- 🔔 Қоңырау иконкасы -->
      <div class="notification-icon" id="notifIconContainer">
         <img src="../assets/images/notificationqalam.png" alt="Notifications" id="notifIcon">
         <span class="notification-dot" id="notifDot"></span>

         <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-item">Хабарлама жоқ</div>
         </div>
      </div>
    </div>
  </div>

  <div class="logo" style="margin-right: 942px;">
    Qalam 
    <img src="../assets/images/navigationimages/LOGOTYPE-QALAM.png" alt="Logo">
  </div>

  <div class="profile">
    <?php if ($email): ?>
      <a href="../pages/profile.php">
        <img src='../assets/images/profileqalamp.png' style='width:18px; height:18px;'> <?= $name ?>
      </a>
      <img src='../assets/images/xpqalam.png' style='width:18px; height:18px;'> <?= $xp ?>
      <img src='../assets/images/coinqalam.png' style='width:18px; height:18px;'> <?= $coins ?>
      <a href="../auth/logout.php" class="logout-btn"> Шығу </a>
      <div class="corzina">
      <a href="../pages/corzina.php"><img src="../assets/images/navigationimages/corzina.png" style='width:18px; height:18px;' alt="Корзина">
  <div class="corzina-badge">3</div> <!-- Мысалы, 3 зат -->
</div>
    <?php else: ?>
      <a href="../login_register.php"> Тіркелу </a>
    <?php endif; ?>
  </div>
</div>

<script>
function toggleBurgerMenu() {
  const content = document.getElementById('burger-content');
  content.style.display = content.style.display === 'flex' ? 'none' : 'flex';
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifIconContainer = document.getElementById('notifIconContainer');
    const notifDropdown = document.getElementById('notifDropdown');

    // 🔔 Хабарламаларды жүктеу
    fetch('../pages/get_notifications.php')
        .then(response => response.json())
        .then(data => {
            notifDropdown.innerHTML = '';
            if (data.notifications.length > 0) {
                notifIconContainer.classList.add('active'); // анимация қосу
                data.notifications.forEach(notif => {
                    const a = document.createElement('a');
                    a.className = 'notif-item';
                    a.href = notif.link;
                    a.textContent = notif.message;
                    notifDropdown.appendChild(a);
                });
            } else {
                notifIconContainer.classList.remove('active'); // анимация өшіру
                notifDropdown.innerHTML = '<div class="notif-item">Хабарлама жоқ</div>';
            }
        });

    // 🔕 Қоңырауды басқанда ашу + оқылды деп белгілеу
    notifIconContainer.addEventListener('click', function (event) {
        event.stopPropagation();
        notifDropdown.style.display = notifDropdown.style.display === 'flex' ? 'none' : 'flex';

        // хабарламаларды оқылды деп белгілеу
        fetch('../pages/read_notifications.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notifIconContainer.classList.remove('active'); // шайқалуды тоқтату
                }
            });
    });

    // Бос жерді басқанда жабу
    document.body.addEventListener('click', function () {
        notifDropdown.style.display = 'none';
    });
});
</script>
</body>
</html>