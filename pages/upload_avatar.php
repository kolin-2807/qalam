<?php
session_start();
require '../config.php'; // config.php жолын өз проектіңе қарай өзгерте аласың

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$target_dir = "../uploads/";
$avatar_name = $email . ".jpg";
$target_file = $target_dir . basename($avatar_name);

// Файл жүктеу
if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
    // Базаға жолын жазу
    $avatar_path = "uploads/" . $avatar_name;
    $stmt = $conn->prepare("UPDATE users SET avatar=? WHERE email=?");
    $stmt->bind_param("ss", $avatar_path, $email);
    $stmt->execute();

    header("Location: profile.php");
    exit();
} else {
    echo "Қате: сурет жүктелмеді.";
}
?>
