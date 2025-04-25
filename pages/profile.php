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
  <style>
    body {
      font-family: 'Press Start 2P', cursive;
      /*background: url('../fon/ChatGPTFon.png') no-repeat center center fixed;*/
      background-color: #fffbaa;
      background-size: cover;
      color: white;
      margin: 0;
      padding: 0;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #111;
      padding: 20px 30px;
      border-bottom: 1px solid yellow;
      width: 100%;
      box-sizing: border-box;
    }

    .logo {
      font-size: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo img {
      width: 40px;
      height: 40px;
      transition: transform 0.3s ease-in-out;
    }

    .logo img:hover {
      transform: rotate(-5deg) scale(1.1);
    }

    .nav {
      display: flex;
      justify-content: center;
      gap: 25px;
      flex-wrap: wrap;
      max-width: 60vw;
    }

    .nav img {
      width: 48px;
      height: 48px;
      cursor: pointer;
      image-rendering: pixelated;
      transition: transform 0.2s ease-in-out;
    }

    .nav img:hover {
      transform: scale(1.2);
      box-shadow: 0 0 12px rgba(255, 255, 255, 0.3);
    }

    .profile {
      font-size: 14px;
      padding: 10px 18px;
      background: #333;
      /*border-radius: 10px;*/
      display: flex;
      align-items: center;
      gap: 12px;
      
    }

    .profile a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .profile a:hover {
      color: yellow;
    }

    .main-content {
      display: flex;
      width: 100%;
      padding: 40px;
      box-sizing: border-box;
      gap: 30px;
    }
    .left-panel h2 {
      color: #fff200;
    }

    .left-panel {
      width: 45%;
      background: rgba(0,0,0,0.4);
      padding: 20px;
      border-radius: 20px;
      backdrop-filter: blur(5px);
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .hero-block {
      background: rgba(255,255,255,0.05);
      border: 1px solid #ffffbb;
      padding: 12px;
      /*border-radius: 14px;*/
      font-size: 10px;
    }

    .xp-bar {
      width: 100%;
      height: 20px;
      background: #333;
      border: 2px solid #fff;
      border-radius: 12px;
      overflow: hidden;
      margin: 10px 0;
    }

    .xp-fill {
      height: 100%;
      background: linear-gradient(to right, #ffffbb, #00ddff);
    }

    .quote {
      color: #00ddff;
      font-style: italic;
    }

    .edit-btn {
      display: inline-block;
      padding: 10px 18px;
      background: #00ffa0;
      color: black;
      /*border-radius: 10px;*/
      text-decoration: none;
      font-size: 12px;
    }

    .level-up-banner {
      position: fixed;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: yellow;
      color: black;
      font-size: 18px;
      padding: 20px 30px;
      border: 4px dashed red;
      z-index: 9999;
      font-family: 'Press Start 2P', cursive;
      display: none;
      animation: popin 1s ease-in-out;
      text-align: center;
      box-shadow: 0 0 30px rgba(255, 255, 255, 0.7);
    }

    @keyframes popin {
      0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
      30% { transform: translate(-50%, -50%) scale(1.2); opacity: 1; }
      70% { transform: translate(-50%, -50%) scale(1); }
      100% { opacity: 0; }
    }

    .right-panel {
      width: 55%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .flip-container {
      perspective: 1000px;
    }

    .flipper {
      position: relative;
      width: 480px;
      height: 250px;
      transition: 0.8s;
      transform-style: preserve-3d;
    }

    .flip-container:hover .flipper {
      transform: rotateY(180deg);
    }

    .front, .back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 0 30px rgba(0, 255, 160, 0.2);
    }

    .front {
      background: linear-gradient(135deg, #101010, #1c1c1c);
      color: #f4f4f4;
      display: flex;
      align-items: center;
      padding: 25px;
    }

    .back {
      background: #141414;
      color: #eee;
      transform: rotateY(180deg);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .card-header {
      position: absolute;
      top: 18px;
      left: 25px;
      font-size: 16px;
      color:rgba(31, 163, 48, 0.71);
    }

    .avatar {
      width: 140px;
      height: 140px;
      border-radius: 12px;
      border: 2px solid #fff;
      object-fit: cover;
      margin-right: 30px;
    }

    .info {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .info p {
      font-size: 11px;
      margin: 5px 0;
    }

    .info p span {
      color:rgb(203, 218, 39);
    }

    .bottom-left, .bottom-right {
      position: absolute;
      bottom: 14px;
      font-size: 10px;
      color: #bbb;
    }

    .bottom-left {
      left: 25px;
    }

    .bottom-right {
      right: 25px;
    }

    .back h3 {
      font-size: 12px;
      margin-bottom: 12px;
      color:rgba(31, 163, 48, 0.71);
    }

    .back p {
      font-size: 10px;
      margin: 4px 0;
    }

    .back img {
      margin-top: 10px;
      width: 80px;
      height: 80px;
    }
  </style>
</head>
<body>

<div class="header">
  <div class="logo">
    Qalam 
    <img src="../assets/navigationimages/LOGOTYPE-QALAM.png" alt="Logo">
  </div>
  <div class="nav">
    <a href="../pages/tasks.php"><img src="../assets/navigationimages/SvitokQALAM.png" alt="Courses"></a>
    <a href="#"><img src="../assets/navigationimages/KubokQALAM.png" alt="League"></a>
    <a href="#"><img src="../assets/navigationimages/homeQALAM.png" alt="Home"></a>
    <a href="#"><img src="../assets/navigationimages/MozgQALAM.png" alt="Clubs"></a>
    <a href="#"><img src="../assets/navigationimages/CherepQALAM.png" alt="Subs"></a>
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
