<?php
header('Content-Type: application/json; charset=utf8');
include 'bd.php';

// Увімкнення логування для дебагу
ini_set('display_errors', 0);
error_reporting(E_ALL);
error_log("get_favorites.php called");

// Отримуємо email користувача
$email = $_POST['email'] ?? '';
error_log("Received email: $email");

if (empty($email)) {
    error_log("No email provided");
    echo json_encode([]);
    exit;
}

// Отримуємо ID користувача
$stmt = $conn->prepare("SELECT ID FROM User WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    error_log("User not found for email: $email");
    echo json_encode([]);
    exit;
}

$user = $result->fetch_assoc();
$user_id = $user['ID'];
error_log("User ID: $user_id");

// Отримуємо улюблені медитації
$stmt = $conn->prepare("
    SELECT m.Title
    FROM Favorite f
    JOIN Meditation m ON f.MeditationID = m.ID
    WHERE f.UserID = ?
    ORDER BY f.DateAdded DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = $row;
}

error_log("Favorites retrieved: " . print_r($favorites, true));
echo json_encode($favorites);

$stmt->close();
$conn->close();
?>