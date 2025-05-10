<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginregister.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$plan = $_GET['plan'] ?? 'junior';

$allowed_plans = ['junior', 'middle', 'full'];
if (!in_array($plan, $allowed_plans)) {
    die("❌ Жоспар табылмады.");
}

// ❗ Жоспар таңдалып, сұраныс базаға жазылады
$stmt = $conn->prepare("UPDATE users SET access_level = ? WHERE id = ?");
$stmt->bind_param("si", $plan, $user_id);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Kaspi төлем</title>
  <link rel="stylesheet" href="../assets/style/Kaspiqr.css">
</head>
<body>
  <div class="qr-container" style="text-align:center; padding:40px;">
    <div class="qr-card">
      <h2><?= ucfirst($plan) ?> жоспары үшін төлем жасаңыз</h2>
      <img src="../assets/images/navigationimages/qaspibuy.jpg" width="300"><br><br>
      <p class="qr-plan">
        <?php
          if ($plan == 'junior') echo " Junior курстар мен сертификаттар";
          elseif ($plan == 'middle') echo " Middle курстар + жүлделер";
          elseif ($plan == 'full') echo " Толық контент пен жұмыс ұсыныс!";
        ?>
      </p>
      <p style="margin-top:20px; color:#ccc;">Төлем жасалған соң админ растаған кезде контент ашылады </p>
    </div>
  </div>
  <div>
  <a class="back-link" href="../pages/user_page.php">Негізгі бетке оралу</a>
</div>
</body>
</html>
