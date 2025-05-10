<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require '../config.php';

if (!isset($_SESSION['email'])) {
    // Логин болмаған жағдайда да сайт ашылуы керек болса, redirect ЖАСАМА!
    // Егер redirect қажет болса, басқа жерде, мысалы тапсырма бетінде ғана жаса

    // Тек $email-ді null деп белгіле:
    $email = null;
    $user = null;
    $name = 'Қонақ';
    $xp = 0;
    $coins = 0;
} else {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $name = htmlspecialchars($user['name'] ?? 'Player');
    $xp = $user['xp'] ?? 0;
    $coins = $user['coins'] ?? 0;
}
?>
<?php include '../includes/header.php'; ?>


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
  <iframe width="400" height="200" src="https://www.youtube.com/embed/34Rp6KVGIEM?si=LLwf0I1Ba0QQfoGa" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
    <p>Бастапқы деңгейдегі жазылым:<br>Бастапқы деңгейдегі курстар</p>
  </div>

  <div class="plan">
    <h3>Silver</h3>
    <img src="../assets/images/Silver.svg" alt="Silver">
    <p>Орта деңгейдегі жазылым:<br>Орта деңгейгі дейінгі<br>курстар және сертификаттар</p>
  </div>

  <div class="plan">
    <h3>Gold</h3>
    <img src="../assets/images/Gold.svg" alt="Gold">
    <p>Жоғарғы деңгейдегі жазылым:<br>Барлық деңгейдегі курстар<br>және артықшылықтар</p>
  </div>

</div>
 <a class="tolygyrak" href="../pages/Plans.php">Толығырақ</a>
<div>
<h3 class="preimushestva-title">Біздің ерекшеліктеріміз</h3>
</div>
<div class="preimuchestva">

  <div>
  <h4>Қызықты</h4>
    <img src="../assets/images/nashipreimushestva.png" alt="K">
    <p>уақытыңызды көңілді пайдаланыңыз<br>және үйреніңіз</p>
  </div>
  <div>
  <h4>Геймификация</h4>
    <img src="../assets/images/nashipreimushestva2.png" alt="G">
    <p>ойын элементтері арқылы<br> ностальгияда болыңыз</p>
  </div>
  <div>
  <h4>Үнемділік</h4>
    <img src="../assets/images/nashipreimushestva3.png" alt="Y">
    <p>Уақытыңызды үнемдеңіз<br>ыңғайлы әрі тартымды интерфейс</p>
  </div>
  <div>
  <h4>Идея</h4>
    <img src="../assets/images/nashipreimushestva4.png" alt="I">
    <p>біздің курстардан шабыт <br>алып өз жобаңызды бастаңыз</p>
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
  "Қош келдің досым!",
  "Code Quest – тек сені күтіп тұр!",
  "Сенде бүгін ерекше күн болады!",
  "XP жинап — рейтингке қатыс!",
  "Бүгінгі күнің сәтті өтсін!",
  "Ешқашан берілме, тек алға!",
  "Мүмкін жазылымдарды қарап өтеміз?",
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

<script>
  const observer = new IntersectionObserver(entries => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, index * 200);
        observer.unobserve(entry.target);
      }
    });
  });

  const blocks = document.querySelectorAll('.preimuchestva > div');
  blocks.forEach(block => observer.observe(block));
</script>


<?php include '../includes/footer.php'; ?>

</body>
</html>
