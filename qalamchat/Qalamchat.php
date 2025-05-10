<?php
include '../includes/header.php';
require '../config.php';

$name = $_SESSION['name'] ?? 'Қонақ';
$allUsers = [];

if ($conn) {
    $res = $conn->query("SELECT name FROM users WHERE name != '$name'");
    while($row = $res->fetch_assoc()) {
        $allUsers[] = $row['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Q-hub – Qalam</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/Qalamchat.css">
</head>
<body>

<div class="container">
    <div class="users-list">
        <h3>Q-hub</h3>
        <?php foreach ($allUsers as $user): ?>
            <div class="user" data-name="<?= $user ?>"><?= $user ?></div>
        <?php endforeach; ?>
    </div>

    <div class="chat-section">
        <h3>Чат ➔ <span id="chatWith">---</span></h3>
        <div id="all_mess"></div>
        <form id="messForm" class="message-box">
            <textarea id="message" placeholder="Хабарлама жаз..." required></textarea>
            <input type="hidden" id="name" value="<?= $name ?>">
            <input type="hidden" id="receiver">
            <button type="submit">Жіберу</button>
        </form>
    </div>
</div>

<!-- 📦 JS кітапханалар -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://localhost:3000/socket.io/socket.io.js"></script>

<!-- ✅ Барлық логика бір жерде, document.ready ішінде -->
<script>
$(document).ready(function () {
    let selectedUser = null;
    const socket = io.connect('http://localhost:3000');
    const me = $("#name").val();

    $(".user").click(function () {
        selectedUser = $(this).text().trim();
        $("#chatWith").text(selectedUser);
        $("#receiver").val(selectedUser);
        $("#all_mess").html('');
    });

    $("#messForm").submit(function (e) {
        e.preventDefault();
        const msg = {
            name: me,
            receiver: $("#receiver").val(),
            mess: $("#message").val()
        };

        console.log("📤 Жіберіліп жатыр:", msg);
        socket.emit('send mess', msg);
        $("#message").val('');
    });

    // Обработка нажатия клавиши Enter в поле ввода сообщения
    $("#message").keydown(function (e) {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault(); // Предотвращаем добавление новой строки
            $("#messForm").submit(); // Отправляем форму
        }
    });

    socket.on('add mess', function (data) {
        const you = $("#receiver").val();
        if ((data.name === me && data.receiver === you) || (data.name === you && data.receiver === me)) {
            const cls = data.name === me ? 'me' : 'other';
            $("#all_mess").append(`<div class="message ${cls}"><b>${data.name}:</b> ${data.mess}</div>`);
        }
    });
});
</script>

</body>
</html>
