<?php
session_start();
include 'bd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Користувач';

// Завантаження улюблених медитацій
$stmt = $conn->prepare("SELECT m.ID, m.Title FROM Favorite f JOIN Meditation m ON f.MeditationID = m.ID WHERE f.UserID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Мій профіль</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header, footer {
            text-align: center;
            padding: 20px;
            background-color: #7b7b5f;
            color: white;
        }

        header h1 {
            margin: 0;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px 20px;
        }

        .favorites {
            width: 100%;
            max-width: 900px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .favorites h3 {
            font-size: 1.8em;
            text-align: center;
            color: #003300;
            margin-bottom: 20px;
        }

        .favorites ul {
            list-style-type: none;
            padding: 0;
        }

        .favorites li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 12px;
            background-color: #f4f4f4;
            border-left: 5px solid #7b7b5f;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .favorites li:hover {
            background-color: #eaeaea;
            transform: translateY(-2px);
        }

        .favorites button {
            background-color: #6a6a4e;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.2s;
        }

        .favorites button:hover {
            background-color: #4f4f38;
            transform: scale(1.05);
        }

        footer {
            font-size: 0.9em;
            background-color: #7b7b5f;
            color: white;
            padding: 15px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            align-items: center;
        }

        nav a, nav button {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            background-color: #6a6a4e;
            border-radius: 30px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        nav a:hover, nav button:hover {
            background-color: #4f4f38;
            transform: scale(1.05);
        }

        #welcome-msg {
            font-size: 2em;
            color: #003300;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Профіль користувача</h1>
        <nav>
            <a href="home.php">На головну</a>
            <button id="logout-btn">Вийти</button>
        </nav>
    </header>

    <main>
        <section id="profile-info">
            <h2 id="welcome-msg">Ласкаво просимо, <?php echo htmlspecialchars($username); ?>!</h2>
            <div class="favorites">
                <h3>Улюблені медитації:</h3>
                <ul id="favorites-list">
                    <?php if (empty($favorites)): ?>
                        <li>Поки що немає улюблених медитацій.</li>
                    <?php else: ?>
                        <?php
                        $meditationFiles = [
                            1 => 'meditation-breathing.php',
                            2 => 'meditation-emotional-balance.php',
                            3 => 'meditation-focus.php',
                            4 => 'meditation-harmony.php',
                            5 => 'meditation-inner-peace.php',
                            6 => 'meditation-positive-thinking.php',
                            7 => 'meditation-relaxation.php',
                            8 => 'meditation-sleep.php'
                        ];
                        foreach ($favorites as $fav):
                            $file = $meditationFiles[$fav['ID']] ?? '#';
                        ?>
                            <li>
                                <?php echo htmlspecialchars($fav['Title']); ?>
                                <button onclick="window.location.href='<?php echo $file; ?>?type=<?php echo $fav['ID']; ?>'">Детальніше</button>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2025 Додаток для медитацій</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Обробка виходу
            document.getElementById("logout-btn").addEventListener("click", () => {
                fetch('logout.php')
                    .then(() => {
                        window.location.href = "home.php";
                    })
                    .catch(error => console.error('Помилка при виході:', error));
            });
        });
    </script>
</body>
</html>