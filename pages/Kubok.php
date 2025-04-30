<?php
include '../includes/header.php';
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];
$user_stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/Kubok.css">
    <title>Raitings</title>
</head>
<body>
<div class="raiting-container">
<h3>Raitings</h3>
<div class="raiting-back">
<div class="leaderboard">
  <div class="leaderboard-header">
    <div>#</div>
    <div>User ID</div>
    <div>Name</div>
    <div>Points</div>
    <div>Level</div>
    <div>Progress</div>
  </div>

  <?php
  $i = 1;
  $sql = "SELECT * FROM users ORDER BY xp DESC LIMIT 10";
  $result = $conn->query($sql);

  while ($row = $result->fetch_assoc()):
      $percent = min(100, floor($row['xp'] / 20));
  ?>
    <div class="leaderboard-row">
      <div><?= $i++ ?></div>
      <div>#U<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT) ?></div>
      <div><?= htmlspecialchars($row['username']) ?></div>
      <div><?= $row['xp'] ?></div>
      <div><?= $row['level'] ?></div>
      <div><?= $percent ?>%</div>
    </div>
  <?php endwhile; ?>

  <?php
  $my_xp = $user['xp'];
  $position_sql = "SELECT COUNT(*) AS position FROM users WHERE xp > ?";
  $pos_stmt = $conn->prepare($position_sql);
  $pos_stmt->bind_param("i", $my_xp);
  $pos_stmt->execute();
  $pos_result = $pos_stmt->get_result()->fetch_assoc();
  $my_place = $pos_result['position'] + 1;
  $my_percent = min(100, floor($my_xp / 20));
  ?>
  <div class="leaderboard-current-user">
      <div><?= $my_place ?></div>
      <div>#U<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></div>
      <div><?= htmlspecialchars($user['username']) ?></div>
      <div><?= $user['xp'] ?></div>
      <div><?= $user['level'] ?></div>
      <div><?= $my_percent ?>%</div>
  </div>
</div>
<div>
    <button class="btn reward">Claim Reward</button>
    <button class="btn progress">View Progress</button>
    <button class="btn course">Go to Course</button>
</div>
</div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>