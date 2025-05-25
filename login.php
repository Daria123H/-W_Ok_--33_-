<?php
session_start();
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM User WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_role'] = $user['RoleID'];
        $_SESSION['username'] = $user['Name'];
        // Перенаправлення на home.php після успішного входу
        header("Location: home.php");
        exit;
    } else {
        // Повернення помилки у JSON, якщо вхід неуспішний
        header('Content-Type: application/json');
        echo json_encode(["error" => "Неправильний email/пароль або такого акаунту не існує."]);
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>