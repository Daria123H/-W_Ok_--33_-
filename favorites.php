<?php
session_start();
include 'bd.php';

if (!isset($_SESSION['user_id'])) {
    echo "Помилка: Користувач не авторизований";
    exit;
}

$user_id = $_SESSION['user_id'];
$meditation_id = $_POST['meditation_id'] ?? null;

if (!$meditation_id) {
    echo "Помилка: ID медитації не вказано";
    exit;
}

// Перевірка, чи медитація існує
$stmt = $conn->prepare("SELECT ID FROM Meditation WHERE ID = ?");
$stmt->bind_param("i", $meditation_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "Помилка: Медитація не існує";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Додавання до улюблених
$stmt = $conn->prepare("INSERT INTO Favorite (UserID, MeditationID) VALUES (?, ?) ON DUPLICATE KEY UPDATE UserID=UserID");
$stmt->bind_param("ii", $user_id, $meditation_id);

if ($stmt->execute()) {
    echo "added";
} else {
    echo "Помилка при додаванні до улюблених: " . $conn->error;
}

$stmt->close();
$conn->close();
?>