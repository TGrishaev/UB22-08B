<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш сайт</title>
    <link rel="stylesheet" href="/css/header.css">
</head>
<body>
<header>
    <div class="container">

        <nav>
            <ul>
                <li><a href="/">Главная</a></li>
                <?php
                if (isset($_SESSION["user_id"])) {
                    echo '<li><a href="/profile.php">Личный кабинет</a></li>';
                    echo '<li><a href="/logout.php">Выйти</a></li>';
                } else {
                    echo '<li><a href="/login.php">Вход</a></li>';
                    echo '<li><a href="/reg.php">Регистрация</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
