<?php
session_start();
require_once '../config.php';

// 🔒 Тек админ ғана көре алады (роль тексеру керек)
if ($_SESSION['role'] !== 'admin') {
    die("⚠️ Тек админге рұқсат.");
}

// 🛠 Қолжетімділікті өзгерту логикасы
if (isset($_GET['toggle']) && isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    $currentStatus = (int)$_GET['toggle'];
    $newStatus = $currentStatus === 1 ? 0 : 1;

    $stmt = $conn->prepare("UPDATE users SET access_granted = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $userId);
    $stmt->execute();

    header("Location: admin_payments.php");
    exit();
}

// 👥 Барлық пайдаланушыларды алу
$users = $conn->query("SELECT id, name, email, access_level, access_granted FROM users");
?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Qalam Admin — Қолжетімділік</title>
  <link rel="stylesheet" href="../assets/style/admin-panel.css">
  <style>
    body {
      background-color: #111;
      color: white;
      font-family: 'Press Start 2P', cursive;
      padding: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 10px;
    }
    th, td {
      border: 1px solid #444;
      padding: 8px;
      text-align: center;
    }
    .grant-btn {
      background-color: #00cc66;
      color: black;
      padding: 4px 8px;
      text-decoration: none;
    }
    .revoke-btn {
      background-color: #cc0000;
      color: white;
      padding: 4px 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<h1>🧙 Admin панелі: Қолжетімділік басқару</h1>

<table>
  <thead>
    <tr>
      <th>№</th>
      <th>Аты</th>
      <th>Email</th>
      <th>Жоспар</th>
      <th>Қолжетімділік</th>
      <th>Әрекет</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; while ($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= strtoupper($user['access_level']) ?></td>
        <td><?= $user['access_granted'] ? '✅ Ашық' : '❌ Жабық' ?></td>
        <td>
          <?php if ($user['access_granted']): ?>
            <a class="revoke-btn" href="?toggle=1&id=<?= $user['id'] ?>">Қолжетімділікті жабу</a>
          <?php else: ?>
            <a class="grant-btn" href="?toggle=0&id=<?= $user['id'] ?>">Қолжетімділікті беру</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
