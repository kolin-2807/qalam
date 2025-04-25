<?php 

$host = "localhost";
$user = "root";
$password = "";
$database = "qalam";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if ($conn->ping()) {
    //echo "Database connected successfully!";
} else {
    echo "Database connection failed: " . $conn->error;
}


?>