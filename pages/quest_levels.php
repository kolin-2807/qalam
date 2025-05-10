<?php include '../includes/header.php'; ?>
<?php
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../loginregister.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT xp, access_level, access_granted FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$xp = $user['xp'] ?? 0;
$access = $user['access_level'] ?? 'junior';
$granted = $user['access_granted'] ?? 0;

$level = floor($xp / 100);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Qalam Quest Levels</title>
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/pixel-operator" type="text/css"/>
  <link rel="stylesheet" href="../assets/style/quest-levels.css">
</head>
<body>
  <h1 class="title">QALAM QUEST LEVELS</h1>

  <div class="levels-container">
    <!-- Level 1 – барлығына ашық -->
    <div class="level-card unlocked">
      <img src="../assets/images/levels/spring.png" alt="Spring">
      <h3>Level 1 — Көктем</h3>
      <a href="level1_map.php" class="enter-btn">Enter</a>
    </div>

    <!-- Level 2 – тек middle және full -->
    <div class="level-card <?= (in_array($access, ['middle', 'full']) && $granted == 1) ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/summer.png" alt="Summer">
      <h3>Level 2 — Жаз</h3>
      <?= (in_array($access, ['middle', 'full']) && $granted == 1) ? '<a href="tasks.php?level=2" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>

    <!-- Level 3 – тек full -->
    <div class="level-card <?= ($access === 'full' && $granted == 1) ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/fall.png" alt="Fall">
      <h3>Level 3 — Күз</h3>
      <?= ($access === 'full' && $granted == 1) ? '<a href="tasks.php?level=3" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>

    <!-- Level 4 – тек full -->
    <div class="level-card <?= ($access === 'full' && $granted == 1) ? 'unlocked' : 'locked' ?>">
      <img src="../assets/images/levels/winter.png" alt="Winter">
      <h3>Level 4 — Қыс</h3>
      <?= ($access === 'full' && $granted == 1) ? '<a href="tasks.php?level=4" class="enter-btn">Enter</a>' : '<span class="lock-icon">🔒</span>' ?>
    </div>
  </div>

  <div>
     <h1 class="title">Тегін видеосабақтар</h1>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/34Rp6KVGIEM?si=cnvCa8_p01MwFkhy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/CfqX2_xY8VQ?si=ptj_ciylGEaH0rH3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/ML5tP8m6SHw?si=6dQeyb_KBKTO1x5D" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          <iframe width="560" height="315" src="https://www.youtube.com/embed/DZvNZ9l9NT4?si=20KDNy5ryAiIHpN9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/SUDNfS_0X-Q?si=Qx9nFkjQ6M_QnKQF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              <iframe width="560" height="315" src="https://www.youtube.com/embed/vMD6-jzgDvI?si=KXbuxeWLiq2prrv5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
      "Қош келдің, досым жайғасып отыр да, бағдарламалауға кіріс!",
      "Code Quest сені күтіп тұр!",
      "Қайта келгеніңе қуаныштымын!",
      "XP жина да — лига ға қатыс!",
      "Бүгінгі күніңе сәттілік тілеймін!"
      "Мүмкін жазылымдарды қарап шығамыз?!"
    ];

    document.addEventListener("DOMContentLoaded", function() {
      const message = botPhrases[Math.floor(Math.random() * botPhrases.length)];
      document.getElementById("bot-speech").textContent = message;
    });
  </script>

<?php include '../includes/footer.php'; ?>
</body>
</html>
