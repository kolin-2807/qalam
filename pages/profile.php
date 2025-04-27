<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'] ?? 'Player';
$name = $user['name'] ?? '';
$city = $user['city'] ?? '';
$state = $user['state'] ?? '';
$phone = $user['phone'] ?? '';
$avatar = !empty($user['avatar']) ? '../' . $user['avatar'] : '../uploads/default.png';
$created = date("d/m", strtotime($user['created_at'] ?? 'now'));
$uid = $user['id'] ?? rand(1000,9999);
$xp = $user['xp'] ?? 0;
$xp = $user['xp'] ?? 0;
$calculatedLevel = floor($xp / 100);
$prevLevel = $_SESSION['prev_level'] ?? $calculatedLevel;
$levelUp = $calculatedLevel > $prevLevel;
$_SESSION['prev_level'] = $calculatedLevel;
$level = $calculatedLevel;

$coins = $_SESSION['coins'] ?? 0;
?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Qalam - Профиль</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/style/profile.css">
</head>
<body>

<div class="header">
  <div class="logo">
    Qalam 
    <img src="../assets/images/navigationimages/LOGOTYPE-QALAM.png" alt="Logo">
  </div>
  <div class="nav">
    <a href="../pages/quest_levels.php"><img src="../assets/images/navigationimages/SvitokQALAM.png" alt="Courses"></a>
    <a href="#"><img src="../assets/images/navigationimages/KubokQALAM.png" alt="League"></a>
    <a href="#"><img src="../assets/images/navigationimages/homeQALAM.png" alt="Home"></a>
    <a href="#"><img src="../assets/images/navigationimages/MozgQALAM.png" alt="Clubs"></a>
    <a href="#"><img src="../assets/images/navigationimages/CherepQALAM.png" alt="Subs"></a>
  </div>
  <div class="profile">
    <a href="profile.php">👤 <?= $name ?></a> 
      ⭐ <?= $xp ?> XP 
      💰 <?= $coins ?>
  </div>
</div>

<div class="main-content">
  <div class="left-panel">
    <h2> Qalam Hero Stats</h2>

    <div class="hero-block">
      <p>🎖 Q-Level <?= $level ?></p>

      <p>🧠 XP:</p>
      <div class="xp-bar">
        <div class="xp-fill" style="width: <?= min(100, round(($xp / ($level * 100)) * 100)) ?>%;"></div>
      </div>
      <p><?= $xp ?> / <?= $level * 100 ?></p>
    </div>

    <div class="hero-block">
      <p> Марапаттар:</p>
      <ul style="margin-left:15px; font-size:10px;">
        <li>✅ Бірінші тапсырма орындалды</li>
        <li>✅ Профиль жаңартылды</li>
      </ul>
    </div>

    <div class="hero-block">
      <p> Күннің сөзі:</p>
      <p class="quote">"Бүгінгі қадамың — ертеңгі жеңісің!"</p>
    </div>

    <div class="hero-block" style="text-align:center;">
      <a href="edit_profile.php" class="edit-btn"> Профильді өзгерту</a>
    </div>
  </div>

  <div class="right-panel">
    <div class="flip-container">
      <div class="flipper">
        <div class="front">
          <div class="card-header">Qalam Hero ID Card</div>
          <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="avatar">
          <div class="info">
            <p>👤 Аты: <span><?= htmlspecialchars($name) ?></span></p>
            <p>🔤 Лақап аты: <span><?= htmlspecialchars($username) ?></span></p>
            <p>🌆 Қала: <span><?= htmlspecialchars($city) ?><?= $state ? ", $state" : "" ?></span></p>
          </div>
          <div class="bottom-left">📞 <?= htmlspecialchars($phone) ?></div>
          <div class="bottom-right">🕒 <?= $created ?></div>
        </div>
        <div class="back">
          <h3>Qalam Hero Credentials</h3>
          <p>🪪 Рөл: Loop Sorcerer</p>
          <p>🎖 Q-Level <?= $level ?></p>
          <p>🧠 XP: <?= $xp ?> / <?= $level * 100 ?></p>
          <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($email) ?>&size=80x80" alt="QR Code">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="level-up-banner" id="levelBanner">
  🎉 LEVEL UP! <br> Құттықтаймыз, жаңа деңгей! 🚀
</div>
<audio id="levelSound" src="../assets/levelup.mp3" preload="auto"></audio>

<script>
  const xp = <?= $xp ?>;
  const maxXP = <?= $level * 100 ?>;

  // XP дәл 100-ге бөлінетін болса ғана анимация қосу
  if (xp % 100 === 0 && xp !== 0) {
    const banner = document.getElementById("levelBanner");
    const sound = document.getElementById("levelSound");
    banner.style.display = 'block';
    sound.play();
    setTimeout(() => {
      banner.style.display = 'none';
    }, 12000);
  }
</script>

</body>
</html>
