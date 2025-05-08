<?php
session_start();
header('Content-Type: application/json');
require '../config.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("UPDATE notifications SET status=1 WHERE receiver_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

echo json_encode(['success' => true]);
?>
