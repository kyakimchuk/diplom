<?php
require_once 'functions.php';
session_start();
$functs = new funcs();
?>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/allpages.css" rel="stylesheet">
    <style>
        h2.pagename div {
            margin: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr style="background-color: rgb(75,74,69);">
        <td height="40">
            <div style="color:white; text-align: center; font-size: 1.5em; font-weight: 100;">Контроль результатов обучения олимпиадному программированию</div>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid rgb(75,74,69);">
                <tr>
                    <th width="33%"><div>Примеры решений задач на строки acm.timus.ru</div><hr width="90%" align="left"></th>
                    <th width="33%"><div>Навигация</div><hr width="90%" align="left"></th>
                    <th width="33%"><div>Профиль</div><hr width="90%" align="left"></th>
                </tr>
                <tr class="navigation" valign="top">
                    <td>
                        <div>
                            Поиск наиболее встечающейся подстроки:
                            <a href="examplesolution.php?number=1723">1723</a><br>
                            Палиндромы:
                            <a href="examplesolution.php?number=1297">1297</a>
                            <a href="examplesolution.php?number=1354">1354</a><br>
                            Определение соответствия строки шаблону:
                            <a href="examplesolution.php?number=1102">1102</a>
                            <a href="examplesolution.php?number=1684">1684</a><br>
                            Циклический сдвиг строки:
                            <a href="examplesolution.php?number=1423">1423</a><br>
                            Количество различных подстрок строки:
                            <a href="examplesolution.php?number=1590">1590</a><br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <a href="index.php">Главная</a><br>
                            <a href="solvedtasks.php">Решенные задачи</a><br>
                            <a href="taskrating.php">Рейтинг по задаче</a><br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <?php if (isset($_SESSION['user_id'])) : ?>
                                Вы вошли как: <a href="participants.php"><?php echo $functs->get_user_name($_SESSION['user_id']); ?></a><br>
                                <a href="participants.php">Участники ACM</a><br>
                                <a href='logout.php'>Выйти</a><br>
                            <?php else : ?>
                                Вы не вошли в систему<br>
                                <a href='authorization.php'>Авторизация</a><br>
                            <?php endif; ?>
                            <a href="registration.php">Регистрация</a><br>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <h2 class="pagename"><div>Добро пожаловать!</div></h2>
        </td>
    </tr>
    <tr>
        <td>
            <div style="width: 450px; position:relative; left: 430px;">
                <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Данная система предназначена для централизованного наблюдения за результатами решений задач по олимпиадному программированию, которые&nbsp;представлены на сайтах с архивами задач и автоматической проверкой.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; На данный момент поддерживается работа с двумя сайтами: acm.timus.ru, e-olymp.com.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Имеется возможность не только централизованно наблюдать за результатами, но и просматривать такие выборки данных, которые не&nbsp;представлены на сайтах.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Система может использоваться участниками олимпиадного программирования или их тренерами.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Для одной из тем задач (&quot;Строки&quot;) даны примеры решенных задач, которые были засчитаны на сайте acm.timus.ru, а именно их: краткое&nbsp;условие, идея решения, прокомментированный код программы на языке&nbsp;С++.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Для того, чтобы создать список участников с их id на сайтах, авторизуйтесь.</p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>