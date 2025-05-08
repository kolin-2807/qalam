<?php
session_start();
header('Content-Type: application/json');
require '../config.php';

$user_id = $_SESSION['user_id']; // қазір кірген пайдаланушының id

$query = "SELECT message, link FROM notifications WHERE receiver_id=? AND status=0 ORDER BY created_at DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
      'message' => $row['message'],
      'link' => $row['link']
    ];
}

echo json_encode(['notifications' => $notifications]);
?>
