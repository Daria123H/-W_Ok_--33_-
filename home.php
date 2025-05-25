<?php
session_start();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додаток для медитації</title>
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

        section:not(:last-child) {
            margin-bottom: 10px;
        }

        h2 {
            font-size: 2.5em;
            text-align: center;
            color: #003300;
            margin-bottom: 20px;
        }

        h3 {
            color: #555;
            margin-top: 30px;
            text-align: center;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        .c_text {
            text-align: center;
            font-family: 'Dancing+Script', cursive;
            font-size: 25px;
            text-transform: uppercase;
            margin-top: 90px;
        }

        .home-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .home-text {
            flex: 1;
        }

        .home-image img {
            width: 400px;
            height: auto;
            border-radius: 10px;
        }

        .meditations-container {
            text-align: center;
        }

        .meditation-list {
            list-style: none;
            padding-left: 0;
            margin-top: 40px;
            display: block;
            background-color: #f4f4f4;
            margin: 10px 0;
            padding: 20px;
            border-radius: 8px;
            color: #333;
            transition: all 0.3s ease;
        }

        .meditation-item {
            display: block;
            background-color: #f4f4f4;
            margin: 10px 0;
            padding: 20px;
            border-radius: 8px;
            color: #333;
            transition: all 0.3s ease;
        }

        .meditation-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .meditation-item strong {
            color: #3a413a;
            font-weight: bold;
        }

        .meditation-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .meditation-list article {
            background-color: #ffffff;
            padding: 25px;
            border-left: 5px solid #7b7b5f;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .meditation-list article:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        button {
            background-color: #7b7b5f;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1.1em;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #6a6a4e;
            transform: scale(1.05);
        }

        form {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        form select {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 1em;
        }

        #profile img {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 20px;
        }

        #about {
            padding: 40px 20px;
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        .section-title {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 1em;
            color: #7b7b5f;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 1.1em;
            line-height: 1.6;
            color: #555;
        }

        .card ul {
            list-style-type: none;
            padding-left: 0;
            margin-top: 15px;
        }

        .card ul li {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 10px;
        }

        .card ul li strong {
            color: #7b7b5f;
        }

        .card ul li:last-child {
            margin-bottom: 0;
        }

        header nav ul li a img {
            width: 80px;
            height: 80px;
            margin-top: -25px;
        }

        header nav ul {
            position: absolute;
            left: 0;
            margin: 0;
            padding: 0;
        }

        .auth-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
        }

        .auth-section {
            width: 45%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            font-size: 1em;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input:focus {
            border-color: #7b7b5f;
        }

        small {
            font-size: 0.9em;
            color: #555;
            margin-top: -5px;
            margin-bottom: 15px;
        }

        button {
            font-size: 1.1em;
            padding: 12px;
            background-color: #7b7b5f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6a6a4e;
        }

        p {
            text-align: center;
            margin-top: 10px;
            font-size: 1em;
        }

        a {
            color: #7b7b5f;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            font-size: 1.1em;
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        .favorite-btn {
            background-color: #7b7b5f;
            color: white;
            border: none;
            padding: 6px 14px;
            font-size: 0.9em;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            margin: 20px auto;
        }

        #loginMessage {
            display: none;
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="#home">Головна</a>
            <a href="#meditations">Медитації</a>
            <a href="#about">Про медитації</a>
            <a href="#login" id="login-link" style="display: <?= isset($_SESSION['user_id']) ? 'none' : 'inline' ?>">Увійти</a>
            <a href="profile.php" id="profile-link" style="display: <?= isset($_SESSION['user_id']) ? 'inline' : 'none' ?>">Профіль</a>
            <a href="admin.php" id="admin-link" style="display: <?= (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 1) ? 'inline' : 'none' ?>">Адмін-панель</a>
            <a href="logout.php" id="logout-link" style="display: <?= isset($_SESSION['user_id']) ? 'inline' : 'none' ?>">Вийти</a>
            <ul>
                <li>
                    <a href="#icon">
                        <img src="image-removebg-preview.png" alt="Профіль">
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section id="home">
        <div class="home-content">
            <div class="home-text">
                <p class="c_text">Ласкаво просимо до нашого простору<br> для внутрішньої гармонії!
                Ми створили цей застосунок, щоб допомогти вам знайти спокій,
                розслаблення та натхнення у будь-який момент дня.</p>
            </div>
            <div class="home-image">
                <img src="jared-rice-NTyBbu66_SI-unsplash.jpg" alt="Медитація" />
            </div>
        </div>

        <div class="meditations-container">
            <h3>Рекомендовані медитації</h3>
            <ul class="meditation-list">
                <li><a href="meditation-relaxation.php?type=7" class="meditation-item">
                    <strong>Спокійний ранок:</strong> Медитація для мʼякого пробудження та налаштування на продуктивний день.
                </a></li>
                <li><a href="meditation-breathing.php?type=1" class="meditation-item">
                    <strong>5 хвилин тиші:</strong> Ідеально підходить для короткої паузи в середині дня.
                </a></li>
                <li><a href="meditation-sleep.php?type=8" class="meditation-item">
                    <strong>Перед сном:</strong> Дихальна практика, що готує до глибокого та відновлювального сну.
                </a></li>
            </ul>
        </div>
    </section>

    <section id="meditations">
        <h2>Медитації</h2>
        <div class="meditations-container">
            <div class="filters">
                <form id="meditation-filters">
                    <label for="category">Категорія:</label>
                    <select id="category">
                        <option value="all">Усі</option>
                        <option value="1">Релаксація</option>
                        <option value="2">Сон</option>
                        <option value="3">Концентрація</option>
                        <option value="4">Енергія</option>
                        <option value="5">Зняття тривоги</option>
                    </select>

                    <label for="duration">Тривалість:</label>
                    <select id="duration">
                        <option value="all">Усі</option>
                        <option value="short">Коротка (до 10 хв)</option>
                        <option value="medium">Середня (10–20 хв)</option>
                        <option value="long">Довга (понад 20 хв)</option>
                    </select>

                    <button type="submit">Знайти</button>
                </form>
            </div>

            <div class="meditation-list" id="meditationsContainer">
                <article class="meditation-item" data-category="1" data-duration="long">
                    <h3><a href="meditation-relaxation.php?type=7">Медитація для розслаблення</a></h3>
                    <p>Ця медитація допоможе зняти напруження, розслабити тіло та заспокоїти розум після важкого дня.</p>
                    <a href="meditation-relaxation.php?type=7"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="7" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="3" data-duration="medium">
                    <h3><a href="meditation-focus.php?type=3">Медитація для фокусу</a></h3>
                    <p>Медитація для концентрації допоможе покращити вашу здатність до зосередження та продуктивності в повсякденному житті.</p>
                    <a href="meditation-focus.php?type=3"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="3" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="2" data-duration="short">
                    <h3><a href="meditation-breathing.php?type=1">Медитація на дихання</a></h3>
                    <p>Ця медитація орієнтована на глибоке дихання, яке дозволяє заспокоїти нервову систему і зосередитися на моменті.</p>
                    <a href="meditation-breathing.php?type=1"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="1" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="5" data-duration="medium">
                    <h3><a href="meditation-harmony.php?type=4">Медитація для гармонії</a></h3>
                    <p>Медитація для відновлення внутрішньої гармонії та балансу, яка допомагає знизити рівень стресу.</p>
                    <a href="meditation-harmony.php?type=4"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="4" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="4" data-duration="short">
                    <h3><a href="meditation-positive-thinking.php?type=6">Медитація для позитивного мислення</a></h3>
                    <p>Ця практика допомагає зміцнити позитивне мислення і налаштуватися на успіх у житті.</p>
                    <a href="meditation-positive-thinking.php?type=6"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="6" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="2" data-duration="short">
                    <h3><a href="meditation-sleep.php?type=8">Медитація для сну</a></h3>
                    <p>Медитація, яка допоможе вам розслабитися і заснути, знижуючи рівень тривожності перед сном.</p>
                    <a href="meditation-sleep.php?type=8"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="8" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="4" data-duration="medium">
                    <h3><a href="meditation-emotional-balance.php?type=2">Медитація для емоційної рівноваги</a></h3>
                    <p>Ця медитація допоможе відновити емоційну рівновагу та впоратися з важкими ситуаціями в житті.</p>
                    <a href="meditation-emotional-balance.php?type=2"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="2" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
                <article class="meditation-item" data-category="5" data-duration="long">
                    <h3><a href="meditation-inner-peace.php?type=5">Медитація для внутрішнього спокою</a></h3>
                    <p>Практика для досягнення внутрішнього спокою та звільнення від негативних думок і переживань.</p>
                    <a href="meditation-inner-peace.php?type=5"><button>Почати</button></a>
                    <button class="favorite-btn" data-meditation-id="5" onclick="addToFavorites(event)">Додати до улюблених</button>
                </article>
            </div>
        </div>
    </section>

    <section id="about">
        <h2 class="section-title">Про медитації</h2>
        <div class="card">
            <h3>Що таке медитація?</h3>
            <p>Медитація — це практика зосередження уваги, яка допомагає досягти внутрішнього спокою, знизити рівень стресу та підвищити усвідомленість. Вона використовується вже понад 2 тисячі років у різних культурах і традиціях по всьому світу.</p>
        </div>
        <div class="card">
            <h3>Історія медитації</h3>
            <p>Коріння медитації сягає давніх цивілізацій — Індії, Китаю, Японії. У стародавніх текстах Вед, буддистських сутрах і даоських практиках описано різні методи досягнення внутрішньої гармонії. З часом медитація поширилася на Захід, де її почали застосовувати як ефективний спосіб боротьби зі стресом та тривожністю.</p>
        </div>
        <div class="card">
            <h3>Факти про медитацію</h3>
            <ul>
                <li>Регулярна медитація знижує рівень гормону стресу — кортизолу.</li>
                <li>Медитація покращує якість сну та допомагає боротися з безсонням.</li>
                <li>Дослідження показують, що медитація підвищує концентрацію та памʼять.</li>
                <li>Медитація може знижувати артеріальний тиск і покращувати роботу серця.</li>
                <li>У деяких клініках її використовують як частину терапії при депресії та тривожних розладах.</li>
            </ul>
        </div>
        <div class="card">
            <h3>Користь медитації</h3>
            <p>Медитація допомагає зміцнити психічне і фізичне здоровʼя, знизити рівень стресу, підвищити якість життя та досягти внутрішньої гармонії. Завдяки регулярним практикам можна покращити емоційну стійкість і загальне самопочуття.</p>
        </div>
    </section>

    <section id="auth">
        <h2>Реєстрація / Вхід</h2>
        <section class="auth-container">
            <div id="register" class="auth-section">
                <h3>Створення облікового запису</h3>
                <form id="registerForm" method="POST" action="register.php">
                    <input type="text" id="username" name="username" required placeholder="Ваше ім'я">
                    <input type="email" id="email" name="email" required placeholder="Ваш email">
                    <input type="password" id="password" name="password" required placeholder="Пароль">
                    <input type="password" id="confirm-password" name="confirm-password" required placeholder="Підтвердження паролю">
                    <button type="submit">Зареєструватися</button>
                </form>
            </div>

            <div id="login" class="auth-section">
                <h3>Вхід</h3>
                <form id="loginForm" method="POST" action="login.php">
                    <input type="email" id="login-email" name="email" required placeholder="Ваш email">
                    <input type="password" id="login-password" name="password" required placeholder="Пароль">
                    <button type="submit">Увійти</button>
                </form>
            </div>

            <div id="errorMessage" class="error-message"></div>
            <div id="loginMessage" class="error-message">Будь ласка, увійдіть, щоб додати до улюблених.</div>
        </section>
    </section>

    <section id="profile-section" style="display:none;">
        <h2>Мій профіль</h2>
        <p id="welcome-msg"></p>
        <h3>Улюблені медитації:</h3>
        <ul id="favorites-list"></ul>
    </section>

    <footer>
        <p>© 2025 Додаток для медитацій</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Перевірка авторизації при завантаженні сторінки
            checkAuthStatus();

            // Функція для перевірки статусу авторизації
            function checkAuthStatus() {
                fetch('session_check.php')
                    .then(res => res.json())
                    .then(data => {
                        const isLoggedIn = data.logged_in;
                        const isAdmin = data.role_id === 1;

                        document.getElementById('login-link').style.display = isLoggedIn ? 'none' : 'inline';
                        document.getElementById('profile-link').style.display = isLoggedIn ? 'inline' : 'none';
                        document.getElementById('admin-link').style.display = isLoggedIn && isAdmin ? 'inline' : 'none';
                        document.getElementById('logout-link').style.display = isLoggedIn ? 'inline' : 'none';
                    })
                    .catch(error => console.error('Помилка при перевірці авторизації:', error));
            }

            // Завантаження медитацій
            fetch('load_meditations.php')
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    const meditationsContainer = document.getElementById('meditationsContainer');
                    meditationsContainer.innerHTML = '';

                    const meditationFiles = {
                        1: 'meditation-breathing.php',
                        2: 'meditation-emotional-balance.php',
                        3: 'meditation-focus.php',
                        4: 'meditation-harmony.php',
                        5: 'meditation-inner-peace.php',
                        6: 'meditation-positive-thinking.php',
                        7: 'meditation-relaxation.php',
                        8: 'meditation-sleep.php'
                    };

                    data.forEach(meditation => {
                        const file = meditationFiles[meditation.id] || '#';
                        const article = document.createElement('article');
                        article.className = 'meditation-item';
                        article.setAttribute('data-category', meditation.category_id);
                        article.setAttribute('data-duration', getDurationCategory(meditation.duration));

                        article.innerHTML = `
                            <h3><a href="${file}?type=${meditation.id}">${meditation.title}</a></h3>
                            <p>${meditation.description}</p>
                            <a href="${file}?type=${meditation.id}"><button>Почати</button></a>
                            <button class="favorite-btn" data-meditation-id="${meditation.id}" onclick="addToFavorites(event)">Додати до улюблених</button>
                        `;

                        meditationsContainer.appendChild(article);
                    });
                })
                .catch(error => {
                    console.error('Помилка завантаження медитацій:', error);
                });

            function getDurationCategory(duration) {
                if (duration <= 10) return 'short';
                if (duration <= 20) return 'medium';
                return 'long';
            }

            document.getElementById('meditation-filters').addEventListener('submit', (e) => {
                e.preventDefault();
                const selectedCategory = document.getElementById('category').value;
                const selectedDuration = document.getElementById('duration').value;

                const meditations = document.querySelectorAll('.meditation-item');

                meditations.forEach(article => {
                    const articleCategory = article.getAttribute('data-category');
                    const articleDuration = article.getAttribute('data-duration');

                    const matchesCategory = selectedCategory === 'all' || selectedCategory === articleCategory;
                    const matchesDuration = selectedDuration === 'all' || selectedDuration === articleDuration;

                    article.style.display = matchesCategory && matchesDuration ? 'block' : 'none';
                });
            });

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('register.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url; // Перенаправлення після успішної реєстрації
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data) {
                        document.getElementById('errorMessage').textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Помилка при реєстрації:', error);
                    document.getElementById('errorMessage').textContent = 'Помилка сервера: ' + error.message;
                });
            });

            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data) {
                        if (data.error) {
                            document.getElementById('errorMessage').textContent = data.error;
                        }
                    }
                })
                .catch(error => {
                    console.error('Помилка при вході:', error);
                    document.getElementById('errorMessage').textContent = 'Помилка сервера: ' + error.message;
                });
            });

            window.addToFavorites = function(event) {
                const button = event.target;
                const meditationId = button.getAttribute('data-meditation-id');

                fetch('session_check.php')
                    .then(res => res.json())
                    .then(data => {
                        if (!data.logged_in) {
                            document.getElementById('loginMessage').style.display = 'block';
                            setTimeout(() => {
                                document.getElementById('loginMessage').style.display = 'none';
                            }, 3000);
                            return;
                        }

                        fetch('favorites.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `user_id=${data.user_id}&meditation_id=${meditationId}`
                        })
                        .then(response => response.text())
                        .then(result => {
                            if (result === 'added') {
                                alert('Медитація додана до улюблених!');
                            } else {
                                alert(result);
                            }
                        })
                        .catch(error => {
                            console.error('Помилка при додаванні до улюблених:', error);
                            document.getElementById('errorMessage').textContent = 'Помилка при додаванні до улюблених.';
                        });
                    })
                    .catch(error => console.error('Помилка при перевірці сесії:', error));
            };
        });
    </script>
</body>
</html>