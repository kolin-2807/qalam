<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header("Location: ../auth/login.php?redirect=$redirect");
    exit();
}
