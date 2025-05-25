<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "meditation";

$conn = new mysqli($servername, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Підключення не вдалося: " . $conn->connect_error);
}
?>