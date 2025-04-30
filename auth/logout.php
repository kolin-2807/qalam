<?php
session_start();
session_destroy(); // Барлық сессияны өшіреді
header("Location: ../index.php"); // Басты бетке қайтарады
exit();
