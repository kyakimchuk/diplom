<?php
require_once 'functions.php';
session_start();
echo "<img id='blue' src='images/blue.png' width='1500px;' height='80px;'/>";
echo "<h1>Контроль результатов обучения олимпиадному программированию</h1>";
if (isset($_SESSION['user_id'])) {
    $functs = new funcs();
    echo "Добро пожаловать," . $functs->get_user_name($_SESSION['user_id'])."!<br>";
    echo "<a href='logout.php'>Выйти</a><br>";
    echo "<a href='profile.php'>Мой профиль</a><br>";
} else {
    echo "Вы не вошли в систему<br>";
    echo "<a href='authorization.php'>Авторизация</a><br>";
    echo "<a href='registration.php'>Регистрация</a><br>";
}
?>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0px;
            font-family: Segoe UI;
        }
        h1 {
            position: relative;
            top: -60px;
            text-align: center;
            color: white;
        }
    </style>
</head>
<body>
<a href="solvedtasks.php">Решенные задачи</a><br>
</body>
</html>