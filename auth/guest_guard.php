<?php
if (session_status() === PHP_SESSION_NONE) {
}

if (!isset($_SESSION['email'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: ../loginregister.php?redirect=$redirect");
    exit();
}
