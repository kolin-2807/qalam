<?php
session_start();
session_destroy(); // Барлық сессияны өшіреді
header("Location: ../loginregister.php"); // Басты бетке емес, нақты бар бетке жібереді
exit();
