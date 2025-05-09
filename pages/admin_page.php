<?php
session_start();
require_once '../config.php';

if ($_SESSION['role'] !== 'admin') {
    die("⚠️ Тек админге рұқсат.");
}

// 🔄 Жаңа жоспар орнату + қолжетімділік беру
if (isset($_POST['set_access'])) {
    $userId = (int)$_POST['user_id'];
    $level = $_POST['access_level'];
    $grant = 1;

    $stmt = $conn->prepare("UPDATE users SET access_level = ?, access_granted = ? WHERE id = ?");
    $stmt->bind_param("sii", $level, $grant, $userId);
    $stmt->execute();

    header("Location: admin_page.php");
    exit();
}

// 🔄 Тек қолжетімділікті жабу
if (isset($_GET['revoke']) && isset($_GET['id'])) {
    $userId = (int)$_GET['id'];
    $stmt = $conn->prepare("UPDATE users SET access_granted = 0 WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    header("Location: admin_page.php");
    exit();
}

$users = $conn->query("SELECT id, name, email, access_level, access_granted FROM users");
?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
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
    .grant-form select,
    .grant-form button {
      font-family: inherit;
      font-size: 10px;
      padding: 4px 6px;
    }
    .grant-form button {
      background-color: #00cc66;
      border: none;
      cursor: pointer;
    }
    .revoke-btn {
      background-color: #cc0000;
      color: white;
      padding: 4px 8px;
      text-decoration: none;
      font-size: 10px;
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
            <a class="revoke-btn" href="?revoke=1&id=<?= $user['id'] ?>">Қолжетімділікті жабу</a>
          <?php else: ?>
            <form class="grant-form" method="POST">
              <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
              <select name="access_level" required>
                <option value="">Таңда</option>
                <option value="junior">Junior</option>
                <option value="middle">Middle</option>
                <option value="full">Full</option>
              </select>
              <button type="submit" name="set_access">✅ Рұқсат беру</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
