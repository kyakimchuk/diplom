<?php
require_once 'functions.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $functs = new funcs();
    echo "Добро пожаловать," . $functs->get_user_name($_SESSION['user_id'])."!";
    echo "<a href='logout.php'>Выйти</a>";
    echo "<a href='profile.php'>Мой профиль</a>";
} else {
    echo "Вы не вошли в систему";
    echo "<a href='authorization.php'>Авторизация</a>";
    echo "<a href='registration.php'>Регистрация</a>";
}
?>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<a href="solvedtasks.php">Решенные задачи</a><br>
</body>
</html>