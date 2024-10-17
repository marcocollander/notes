<?php
declare(strict_types=1);

namespace Notes;

require_once 'src/utils/debug.php';

$action = $_GET['action'] ?? null;

?>

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
            <li class="menu__item"><a href="/" class="menu__link">Lista notatek</a></li>
            <li class="menu__item"><a href="/?action=create" class="menu__link">Nowa notatka</a></li>
        </ul>
    </nav>
</header>
<main class="main">
    <section class="section">
        <h2 class="section__heading">Lista notatek</h2>
        <?php if ($action == 'create'): ?>
            <h2>nowa notatka</h2>
        <?php else: ?>
            <h2>lista notatek</h2>
           <?=  htmlentities($action ?? '') ?>
        <?php endif;
?>
    </section>
</main>
<script src="/public/js/main.js"></script>
</body>
</html>
