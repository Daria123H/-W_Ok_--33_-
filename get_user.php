<?php
header('Content-Type: application/json');
include 'bd.php';

$email = $_POST['email'] ?? '';

$stmt = $conn->prepare("SELECT ID, Name FROM User WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode(['success' => true, 'user_id' => $user['ID'], 'username' => $user['Name']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Користувач не знайдений']);
}

$stmt->close();
$conn->close();
?>