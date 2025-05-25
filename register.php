<?php
session_start();
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=utf8');
    echo json_encode(['success' => false, 'message' => 'Метод не дозволений']);
    exit;
}

// Отримання даних із $_POST
$name = $_POST['username'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$confirm_password = $_POST['confirm-password'] ?? null;

if (!$name || !$email || !$password || !$confirm_password) {
    header('Content-Type: application/json; charset=utf8');
    echo json_encode(['success' => false, 'message' => 'Всі поля обовʼязкові']);
    exit;
}

if ($password !== $confirm_password) {
    header('Content-Type: application/json; charset=utf8');
    echo json_encode(['success' => false, 'message' => 'Паролі не співпадають']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Перевірка чи існує користувач з таким email
$stmt = $conn->prepare("SELECT * FROM User WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header('Content-Type: application/json; charset=utf8');
    echo json_encode(['success' => false, 'message' => 'Email вже зареєстрований']);
    exit;
}

// Додаємо користувача з RoleID = 2 (User)
$role_id = 2;
$stmt = $conn->prepare("INSERT INTO User (Name, Email, Password, RegistrationDate, RoleID) VALUES (?, ?, ?, NOW(), ?)");
$stmt->bind_param("sssi", $name, $email, $hashedPassword, $role_id);

if ($stmt->execute()) {
    // Автоматична авторизація після реєстрації
    $stmt = $conn->prepare("SELECT ID, RoleID, Name FROM User WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['user_role'] = $user['RoleID'];
    $_SESSION['username'] = $user['Name'];
    header("Location: home.php");
    exit;
} else {
    header('Content-Type: application/json; charset=utf8');
    echo json_encode(['success' => false, 'message' => 'Помилка при реєстрації: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>