<?php
session_start();
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    // Мәліметтерді жаңарту
    $stmt = $conn->prepare("UPDATE users SET username=?, name=?, phone=?, city=?, state=? WHERE email=?");
    $stmt->bind_param("ssssss", $username, $name, $phone, $city, $state, $email);
    $stmt->execute();

    // Аватар жүктеу
    if (!empty($_FILES["avatar"]["name"])) {
        $avatar_name = $email . ".jpg";
        $avatar_path = "../uploads/" . $avatar_name;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatar_path);

        $avatar_db_path = "uploads/" . $avatar_name;
        $update_avatar = $conn->prepare("UPDATE users SET avatar=? WHERE email=?");
        $update_avatar->bind_param("ss", $avatar_db_path, $email);
        $update_avatar->execute();
    }

    header("Location: profile.php");
    exit();
}

// Мәліметтерді шығару
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Профильді өңдеу</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    body {
      font-family: 'Press Start 2P', cursive;
      background: url('../fon/ChatGPTFon.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
      margin: 0;
      padding: 0;
    }

    .form-container {
      background: rgba(0,0,0,0.8);
      padding: 30px;
      border-radius: 20px;
      width: 420px;
      border: 2px solid #00ffc8;
      box-shadow: 0 0 15px #00ffc8;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"], input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: none;
      font-size: 15px;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: #00ffc8;
      color: black;
      border: none;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #00caa3;
    }

    a.back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #00ffc8;
      text-decoration: none;
    }

    a.back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Профильді өңдеу</h2>
    <form method="POST" action="edit_profile.php" enctype="multipart/form-data">
      <label>Кейіпкер аты (username):</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>

      <label>Атыңыз:</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>

      <label>Телефон:</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">

      <label>Қала:</label>
      <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>">

      <label>Мемлекет:</label>
      <input type="text" name="state" value="<?= htmlspecialchars($user['state'] ?? '') ?>">

      <label>Аватар жүктеу:</label>
      <input type="file" name="avatar" accept="image/*">

      <button type="submit">Сақтау</button>
    </form>

    <a href="profile.php" class="back-link">← Профиль бетіне оралу</a>
  </div>
</body>
</html>
