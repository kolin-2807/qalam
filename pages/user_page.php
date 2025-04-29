<?php include '../includes/header.php'; ?>
<?php

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
    <title>Home</title>
    <link rel="stylesheet" href="../assets/style/style-user.css">
</head>
<body>
<h3 class="course-1">Сіздің курстағы прогресіңіз</h3>
<div class="course-container">
    <div class="course-block">
        <h3 class="course-title">- Python -</h3>
        <div class="progress-bar">
            <div class="progress-fill" style="width: 45%;"></div>
        </div>
        <p class="progress-text">45%</p>
    </div>
    
    <div class="course-description">
        <h4>Code Quest: Beginner</h4>
        <p>Бұл курс бағдарламалаудың ең негізгі ұғымдарын үйретеді. Python тілінде жобалар жасайсың!</p>
    </div>
</div>

<div>
<h3 class="subscriptions-title">Subscriptions</h3>
</div>

<div class="bolik-one">
  
  <div class="plan">
    <h3>Bronze</h3>
    <img src="../assets/images/Bronze.svg" alt="Bronze">
    <p>Самый базовый план: <br> доступ к базовым курсам и форуму.</p>
  </div>

  <div class="plan">
    <h3>Silver</h3>
    <img src="../assets/images/Silver.svg" alt="Silver">
    <p>План с доступом к расширенным <br> курсам и сертификатам.</p>
  </div>

  <div class="plan">
    <h3>Gold</h3>
    <img src="../assets/images/Gold.svg" alt="Gold">
    <p>Полный доступ ко всем курсам, <br> бонусам и персональной поддержке.</p>
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
  "Бүгінгі күнің сәтті өтсін!",
];

document.addEventListener("DOMContentLoaded", function() {
  const message = botPhrases[Math.floor(Math.random() * botPhrases.length)];
  document.getElementById("bot-speech").textContent = message;
});
</script>

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


<?php include '../includes/footer.php'; ?>

</body>
</html>
