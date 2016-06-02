<?php
require_once 'functions.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: http://diplom/index.php");
    exit;
}
$functs = new funcs();
$login = "";
$pass = "";
$error = "";
if (isset($_POST["submitbutton"])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];

    if ($res = $functs->user_exist($login, $pass)) {
        $functs->login($res);
        $error = 2;
    } else
        $error = 1;
}
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
        div.functionsuccess {
            width: 600px;
            border: 1px solid rgb(46,82,31);
            background: rgb(223,240,216);
            padding: 15px;
            border-radius: 9px;
        }
        div.functionmistake {
            width: 600px;
            border: 1px solid #aa0000;
            background: #F8E4DF;
            padding: 15px;
            border-radius: 9px;
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
            <h2 class="pagename"><div>Вход</div></h2>
        </td>
    </tr>
    <tr>
        <td align="center">
            <form method="post">
                <table>
                    <tr>
                        <td>Логин:</td>
                        <td><input type="text" name="login" value="" required></td>
                    </tr>
                    <tr>
                        <td>Пароль:</td>
                        <td><input type="password" name="pass" value="" required></td>
                    </tr>
                </table>
                <div style="margin: 25px;">
                    <input type="submit" value="Войти" name="submitbutton"/>
                </div>
                <?php
                if ($error == 1) {
                    echo "<br><div class='functionmistake'>Логин или пароль введены не верно!</div>";
                }
                if ($error == 2) {
                    echo "<br><div class='functionsuccess'>Вход выполнен успешно!</div>";
                }
                ?>
            </form>
        </td>
    </tr>
</table>
</body>
</html>