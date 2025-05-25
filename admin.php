<?php
session_start();
include 'bd.php';

// Перевірка ролі користувача
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: home.php");
    exit;
}

// Отримання списку користувачів
$usersStmt = $conn->prepare("SELECT u.ID, u.Name, u.Email, r.ID AS RoleID, r.Name AS RoleName FROM User u JOIN Roles r ON u.RoleID = r.ID");
$usersStmt->execute();
$usersResult = $usersStmt->get_result();
$users = [];
while ($row = $usersResult->fetch_assoc()) {
    $users[] = $row;
}

// Отримання списку ролей для випадаючого списку
$rolesStmt = $conn->prepare("SELECT ID, Name FROM Roles");
$rolesStmt->execute();
$rolesResult = $rolesStmt->get_result();
$roles = [];
while ($row = $rolesResult->fetch_assoc()) {
    $roles[] = $row;
}

// Отримання списку медитацій
$meditationsStmt = $conn->prepare("SELECT m.ID, m.Title, m.Description, m.Duration, m.DifficultyLevel, m.AudioVideoLink, c.ID AS CategoryID, c.Name AS CategoryName FROM Meditation m LEFT JOIN Category c ON m.CategoryID = c.ID");
$meditationsStmt->execute();
$meditationsResult = $meditationsStmt->get_result();
$meditations = [];
while ($row = $meditationsResult->fetch_assoc()) {
    $meditations[] = $row;
}

// Завантаження категорій для випадаючого списку
$categories = [];
$result = $conn->query("SELECT ID, Name FROM Category");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}


// Обробка редагування медитації
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_meditation'])) {
    $meditation_id = $_POST['meditation_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $difficulty = $_POST['difficulty'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $audio_video_link = $_POST['audio_video_link'] ?? '';

    if ($meditation_id && $title && $description && $duration && $difficulty && $category_id && $audio_video_link) {
        $stmt = $conn->prepare("UPDATE Meditation SET Title = ?, Description = ?, Duration = ?, DifficultyLevel = ?, CategoryID = ?, AudioVideoLink = ? WHERE ID = ?");
        $stmt->bind_param("ssisssi", $title, $description, $duration, $difficulty, $category_id, $audio_video_link, $meditation_id);
        if ($stmt->execute()) {
            header("Location: admin.php?message=Медитація успішно оновлена");
            exit;
        } else {
            $error = "Помилка при оновленні медитації: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Усі поля обов'язкові для заповнення";
    }
}

// Обробка видалення медитації
if (isset($_GET['delete_meditation'])) {
    $meditation_id = (int)$_GET['delete_meditation'];
    $stmt = $conn->prepare("DELETE FROM Meditation WHERE ID = ?");
    $stmt->bind_param("i", $meditation_id);
    if ($stmt->execute()) {
        header("Location: admin.php?message=Медитація успішно видалена");
        exit;
    } else {
        $error = "Помилка при видаленні медитації: " . $conn->error;
    }
    $stmt->close();
}

// Обробка зміни ролі користувача
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'] ?? '';
    $role_id = $_POST['role_id'] ?? '';

    if ($user_id && $role_id) {
        $stmt = $conn->prepare("UPDATE User SET RoleID = ? WHERE ID = ?");
        $stmt->bind_param("ii", $role_id, $user_id);
        if ($stmt->execute()) {
            header("Location: admin.php?message=Роль користувача успішно оновлена");
            exit;
        } else {
            $error = "Помилка при оновленні ролі: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Помилка: Не вибрано роль";
    }
}

// Обробка видалення користувача
if (isset($_GET['delete_user'])) {
    $user_id = (int)$_GET['delete_user'];

    if ($user_id == $_SESSION['user_id']) {
        $error = "Ви не можете видалити власний акаунт.";
    } else {
        $stmt = $conn->prepare("DELETE FROM Favorite WHERE UserID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM User WHERE ID = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            header("Location: admin.php?message=Користувач успішно видалений");
            exit;
        } else {
            $error = "Помилка при видаленні користувача: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #d7ddd4;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 100px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #7b7b5f;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 10px;
            font-size: 1.2em;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: transform 0.3s;
        }

        nav a:hover {
            transform: scale(1.05);
            text-decoration: none;
        }

        section {
            width: 90%;
            max-width: 1800px;
            padding: 40px 20px;
            margin: 30px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        h2 {
            font-size: 2.5em;
            text-align: center;
            color: #003300;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #7b7b5f;
            color: white;
        }

        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #5bc0de;
            color: white;
        }

        .edit-btn:hover {
            background-color: #31b0d5;
        }

        .delete-btn {
            background-color: #d9534f;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

        .error-message, .success-message {
            font-size: 1.1em;
            text-align: center;
            margin-top: 20px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }

        .edit-form {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="home.php#home">Головна</a>
            <a href="home.php#meditations">Медитації</a>
            <a href="home.php#about">Про медитації</a>
            <a href="home.php#login" id="login-link" style="display: none;">Увійти</a>
            <a href="profile.html" id="profile-link" style="display: inline;">Профіль</a>
            <a href="admin.php" id="admin-link" style="display: inline;">Адмін-панель</a>
            <a href="logout.php" id="logout-link" style="display: inline;">Вийти</a>
        </nav>
    </header>

    <section id="admin-panel">
        <h2>Адмін-панель</h2>

        <!-- Повідомлення про успіх або помилку -->
        <?php if (isset($_GET['message'])): ?>
            <div class="success-message"><?= htmlspecialchars($_GET['message']) ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Список користувачів -->
        <h3>Користувачі</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ім'я</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['ID']) ?></td>
                        <td><?= htmlspecialchars($user['Name']) ?></td>
                        <td><?= htmlspecialchars($user['Email']) ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= $user['ID'] ?>">
                                <select name="role_id" onchange="this.form.submit()">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['ID'] ?>" <?= $role['ID'] == $user['RoleID'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($role['Name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="update_role" value="1">
                            </form>
                        </td>
                        <td>
                            <button class="delete-btn" onclick="if(confirm('Ви впевнені, що хочете видалити цього користувача?')) location.href='admin.php?delete_user=<?= $user['ID'] ?>'">Видалити</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Список медитацій -->
        <h3>Медитації</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Категорія</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meditations as $meditation): ?>
                    <tr>
                        <td><?= htmlspecialchars($meditation['ID']) ?></td>
                        <td><?= htmlspecialchars($meditation['Title']) ?></td>
                        <td><?= htmlspecialchars($meditation['CategoryName'] ?? 'Невідомо') ?></td>
                        <td>
                            <button class="edit-btn" onclick="showEditForm(<?= $meditation['ID'] ?>)">Редагувати</button>
                            <button class="delete-btn" onclick="if(confirm('Ви впевнені, що хочете видалити цю медитацію?')) location.href='admin.php?delete_meditation=<?= $meditation['ID'] ?>'">Видалити</button>
                        </td>
                    </tr>
                    <!-- Форма для редагування медитації -->
                    <tr class="edit-form-row" id="edit-form-<?= $meditation['ID'] ?>" style="display: none;">
                        <td colspan="4">
                            <form method="POST">
                                <input type="hidden" name="meditation_id" value="<?= $meditation['ID'] ?>">
                                <label for="title-<?= $meditation['ID'] ?>">Назва:</label>
                                <input type="text" id="title-<?= $meditation['ID'] ?>" name="title" value="<?= htmlspecialchars($meditation['Title']) ?>" required>

                                <label for="description-<?= $meditation['ID'] ?>">Опис:</label>
                                <textarea id="description-<?= $meditation['ID'] ?>" name="description" required><?= htmlspecialchars($meditation['Description']) ?></textarea>

                                <label for="duration-<?= $meditation['ID'] ?>">Тривалість (хвилини):</label>
                                <input type="number" id="duration-<?= $meditation['ID'] ?>" name="duration" value="<?= htmlspecialchars($meditation['Duration']) ?>" required>

                                <label for="difficulty-<?= $meditation['ID'] ?>">Рівень складності:</label>
                                <select id="difficulty-<?= $meditation['ID'] ?>" name="difficulty" required>
                                    <option value="Beginner" <?= $meditation['DifficultyLevel'] == 'Beginner' ? 'selected' : '' ?>>Початковий</option>
                                    <option value="Intermediate" <?= $meditation['DifficultyLevel'] == 'Intermediate' ? 'selected' : '' ?>>Середній</option>
                                    <option value="Advanced" <?= $meditation['DifficultyLevel'] == 'Advanced' ? 'selected' : '' ?>>Просунутий</option>
                                </select>

                                <label for="category_id-<?= $meditation['ID'] ?>">Категорія:</label>
                                <select id="category_id-<?= $meditation['ID'] ?>" name="category_id" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['ID'] ?>" <?= $category['ID'] == $meditation['CategoryID'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['Name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="audio_video_link-<?= $meditation['ID'] ?>">Посилання на відео/аудіо:</label>
                                <input type="url" id="audio_video_link-<?= $meditation['ID'] ?>" name="audio_video_link" value="<?= htmlspecialchars($meditation['AudioVideoLink']) ?>" required>

                                <button type="submit" name="edit_meditation">Зберегти зміни</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>© 2025 Додаток для медитацій</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('session_check.php')
                .then(res => res.json())
                .then(data => {
                    if (!data.logged_in || data.role_id != 1) {
                        window.location.href = 'home.php';
                    }
                });

            window.showEditForm = function(meditationId) {
                // Приховуємо всі форми редагування
                document.querySelectorAll('.edit-form-row').forEach(form => {
                    form.style.display = 'none';
                });
                // Показуємо потрібну форму
                const form = document.getElementById(`edit-form-${meditationId}`);
                if (form) {
                    form.style.display = 'table-row';
                }
            };
        });
    </script>
</body>
</html>