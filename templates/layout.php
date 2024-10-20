<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notatki</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/public/css/main.css">
</head>
<body>
<div class="wrapper">
<header class="header">
    <div class="logo">
        <img width="60" class="logo__image" src="/public/image/logo.png" alt="Logo portalu">
    </div>
    <h1 class="header__heading">Notatki</h1>
    <nav class="nav">
        <button class="hamburger" type="button">
            <span class="hamburger__item"></span>
            <span class="hamburger__item"></span>
            <span class="hamburger__item"></span>
        </button>
        <ul class="menu">
            <li class="menu__item"><a href="/" class="menu__link">Strona główna</a></li>
            <li class="menu__item"><a href="/?action=create" class="menu__link">Nowa notatka</a></li>
        </ul>
    </nav>
</header>
<main class="main">
    <section class="section">
        <?php

        if (isset($page)) {
            require_once "pages/$page.php";
        } else {
            echo "<h3>Strona nie istnieje</h3";
        }

        ?>

    </section>
</main>
<footer class="footer">
    <div class="footer__description">
        <h3 class="footer__heading">Notatki</h3>
        <p class="copyRight">
            &copy; by FreeCoder październik 2024
        </p>
    </div>
</footer>
</div>
<script src="/public/js/main.js"></script>
</body>
</html>
