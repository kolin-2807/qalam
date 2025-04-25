<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$name = htmlspecialchars($_SESSION['name'] ?? 'Qonaq');
$xp = $_SESSION['xp'] ?? 0;
$coins = $_SESSION['coins'] ?? 0;
?>

<style>
.header {
    background: #111;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 30px;
    border-bottom: 4px dashed yellow;
    font-family: 'Press Start 2P', cursive;
    box-sizing: border-box;
    width: 100%;
}

.header .left-logo,
.header .nav,
.header .profile-box {
    display: flex;
    align-items: center;
}

.left-logo img {
    width: 36px;
    height: 36px;
    margin-left: 8px;
}

.nav {
    gap: 25px;
}

.nav a img {
    width: 40px;
    height: 40px;
    image-rendering: pixelated;
    transition: transform 0.3s ease;
}
.nav a img:hover {
    transform: scale(1.2);
}

.profile-box {
    background: #222;
    border: 2px solid #fff;
    border-radius: 12px;
    padding: 8px 14px;
    gap: 10px;
    font-size: 12px;
}

.profile-box a {
    color: white;
    text-decoration: none;
}
.profile-box a:hover {
    color: yellow;
}

.header > * {
    flex: 1;
    justify-content: center;
}

.header .left-logo {
    justify-content: flex-start;
}

.header .profile-box {
    justify-content: flex-end;
}
</style>

<div class="header">
    <!-- 🔹 Сол жақ: ЛОГО -->
    <div class="left-logo">
        Qalam
        <img src="../assets/navigationimages/LOGOTYPE-QALAM.png" alt="Qalam Logo">
    </div>

    <!-- 🔸 Орта: Навигация иконкалар -->
    <div class="nav">
        <a href="#"><img src="../assets/navigationimages/SvitokQALAM.png" alt="Courses"></a>
        <a href="#"><img src="../assets/navigationimages/KubokQALAM.png" alt="League"></a>
        <a href="#"><img src="../assets/navigationimages/homeQALAM.png" alt="Home"></a>
        <a href="#"><img src="../assets/navigationimages/MozgQALAM.png" alt="Clubs"></a>
        <a href="#"><img src="../assets/navigationimages/CherepQALAM.png" alt="Subs"></a>
    </div>

    <!-- 🔸 Оң жақ: Профиль -->
    <div class="profile-box">
        <a href="profile.php">👤 <?= $name ?></a> |
        ⭐ <?= $xp ?> XP |
        💰 <?= $coins ?>
    </div>
</div>
