<?php
require_once 'functions.php';
session_start();
$functs = new funcs();
$login = "";
$pass = "";
$rpass = "";
$name = "";
$surname = "";
$email = "";
$timusid="";
$errors = array();
$temp = 0;
$connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');

if (isset($_POST["submitbutton"])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $rpass = $_POST['rpass'];
    $name = $_POST['name1'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $timusid = $_POST['timusid'];
    if(!preg_match('|^[A-Z0-9_]+$|i', $login)) {
        $temp = 1;
        $errors[] = "Логин может содержать только английские буквы, цифры и знаки подчеркивания";
    }
    if (strlen($login) > 50) {
        $temp = 1;
        $errors[] = "Длина логина должна быть не более чем 50 символов";
    }
    $loginlist = $connection->query('SELECT login FROM memberlist');
    while ($row = $loginlist->fetch()) {
        if ($row['login'] == $login) {
            $temp = 1;
            $errors[] = "Такой логин уже существует";
        }
    }
    if (strlen($pass) > 50 || strlen($pass)<6) {
        $temp = 1;
        $errors[] = "Длина пароля должна быть не менее 6 символов и не более 50 символов";
    }
    if ($pass != $rpass) {
        $temp = 1;
        $errors[] = "Пароли не совпадают";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]+$|', $name)) {
        $temp = 1;
        $errors[] = "Имя может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($name) > 50) {
        $temp = 1;
        $errors[] = "Длина имени должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]+$|', $surname)) {
        $temp = 1;
        $errors[] = "Фамилия может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($surname) > 50) {
        $temp = 1;
        $errors[] = "Длина фамилии должна быть не более чем 50 символов";
    }
    if (strlen($email) > 50) {
        $temp = 1;
        $errors[] = "Длина email-адреса должна быть не более чем 50 символов";
    }
    if (strlen($timusid) > 10) {
        $temp = 1;
        $errors[] = "Длина timus-id должна быть не более чем 10 цифр";
    }
    if(!preg_match('|^[0-9]*$|', $timusid)) {
        $temp = 1;
        $errors[] = "Timus-id может содержать только цифры";
    }
    if ($temp == 0) {
        $hashed_pass = md5($pass);
        $sql = "INSERT INTO memberlist ( login, pass, name, surname, email, timus_id) VALUES (:login,:pass,:name,:surname,:email,:timusid)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $hashed_pass, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':timusid', $timusid, PDO::PARAM_INT);
        $stmt->execute();
        $temp = 2;
    }
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
            <?php if ($temp == 2) :
                $login = "";
                $pass = "";
                $rpass = "";
                $name = "";
                $surname = "";
                $email = "";
                $timusid = "";
            endif;
            ?>
            <h2 class="pagename"><div>Регистрация</div></h2>
        </td>
    </tr>
    <tr>
        <td align="center">
            <form method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Логин:</td>
                        <td><input type="text" name="login" value="<?php echo $login; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Пароль:</td>
                        <td><input type="password" name="pass" value="<?php echo $pass; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Повторение пароля:</td>
                        <td><input type="password" name="rpass" value="<?php echo $rpass; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Имя:</td>
                        <td><input type="text" name="name1" value="<?php echo $name; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Фамилия:</td>
                        <td><input type="text" name="surname" value="<?php echo $surname; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Email-адрес:</td>
                        <td><input type="email" name="email" value="<?php echo $email; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Timus-id:</td>
                        <td><input type="text" name="timusid" value="<?php echo $timusid; ?>"></td>
                    </tr>
                </table>
                <div style="margin: 25px;">
                    <input type="submit" value="Зарегистрироваться" name="submitbutton"/>
                </div>
                <?php if ($temp == 1) {
                    echo "<div class='functionmistake'>";
                    echo "Данные введены неверно. Ошибки:<br/>";
                    for ($i = 0; $i < count($errors); $i++) {
                        echo $errors[$i] . "<br/>";
                    }
                    echo "</div>";
                } elseif ($temp == 2) {
                    echo "<div class='functionsuccess'>";
                    echo "Вы успешно зарегистрированы!";
                    echo "</div>";
                }
                ?>
            </form>
        </td>
    </tr>
</table>
</body>
</html>