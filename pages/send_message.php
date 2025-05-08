// мысал ретінде:
session_start();
require '../config.php';

$sender_id = $_SESSION['user_id']; // жіберуші (қазір кірген пайдаланушы)
$receiver_id = $_POST['receiver_id']; // хабар алушының id
$message = "Сізге жаңа хабарлама келді!"; // көрінетін хабарлама мәтіні
$link = "Qalamchat.php?user=" . $sender_id; // Чат парағына сілтеме

$stmt = $conn->prepare("INSERT INTO notifications (message, link, receiver_id, sender_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $message, $link, $receiver_id, $sender_id);
$stmt->execute();
