<?php
$host = '127.0.0.1';
$dbname = 'meditation';
$username = 'root';
$password = '';

$type = $_GET['type'] ?? '5';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Зміна запиту: припускаємо, що параметр type — це назва Title або ID
    $stmt = $pdo->prepare("SELECT * FROM meditation WHERE ID = :id");
    $stmt->execute(['id' => $type]);
    
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Помилка підключення: " . $e->getMessage();
    exit;
}

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= $data ? $data['Title'] : 'Медитація' ?></title>
    <link rel="stylesheet" href="styles_home.css">
</head>
<body>
<header>
    <nav>
        <a href="home.php">Головна</a>
        <a href="#">Медитації</a>
        <a href="#">Про медитації</a>
        <a href="#">Увійти</a>
    </nav>
</header>

<section id="meditation-details">
<?php if ($data): ?>
    <h1><?= htmlspecialchars($data['Title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($data['Description'])) ?></p>

    <h2>Інструкції</h2>
    <p><?= nl2br(htmlspecialchars($data['Instructions'])) ?></p>

    <h3>Тривалість: <?= htmlspecialchars($data['Duration']) ?></h3>

    <h2>Подивіться відео або аудіо медитації:</h2>
    <div id="youtube-video">
        <iframe width="560" height="315" src="<?= htmlspecialchars($data['AudioVideoLink']) ?>" frameborder="0" allowfullscreen></iframe>
    </div>
<?php else: ?>
    <p>Медитацію не знайдено.</p>
<?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 Додаток для медитацій</p>
</footer>
</body>
</html>
