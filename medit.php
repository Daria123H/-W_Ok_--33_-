<?php
$type = $_GET['type'] ?? 'default';

$meditations = [
    'dykhannya' => [
        'title' => 'Медитація для дихання',
        'description' => 'Ця медитація допоможе зосередитися на диханні.',
        'instructions' => '1. Сядьте зручно.<br>2. Зосередьте увагу на вдиху та видиху.',
        'duration' => '10 хвилин',
        'video' => 'https://www.youtube.com/embed/XXXXXX'
    ],
    'fokus' => [
        'title' => 'Медитація для фокусу',
        'description' => 'Покращує концентрацію та уважність.',
        'instructions' => '1. Знайдіть тихе місце.<br>2. Слухайте дихання.',
        'duration' => '15 хвилин',
        'video' => 'https://www.youtube.com/embed/CTS6E_0oAJg'
    ],
    'rivnovaga' => [
        'title' => 'Медитація для емоційної рівноваги',
        'description' => 'Відновлює емоційну стабільність.',
        'instructions' => '1. Сядьте в зручну позу.<br>2. Уявляйте, як емоції стабілізуються.',
        'duration' => '11 хвилин',
        'video' => 'https://www.youtube.com/embed/8wuWlv_C5w0'
    ]
];

$data = $meditations[$type] ?? null;
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= $data ? $data['title'] : 'Медитація' ?></title>
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
    <h1><?= $data['title'] ?></h1>
    <p><?= $data['description'] ?></p>

    <h2>Інструкції</h2>
    <p><?= $data['instructions'] ?></p>

    <h3>Тривалість: <?= $data['duration'] ?></h3>

    <h2>Подивіться відео медитації:</h2>
    <div id="youtube-video">
        <iframe width="560" height="315" src="<?= $data['video'] ?>" frameborder="0" allowfullscreen></iframe>
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
