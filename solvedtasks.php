<?php
require_once 'functions.php';
require_once 'simple_html_dom.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
$functs = new funcs();
$site = 0;
$theme = "";
$id_stud = "";
if (isset($_POST['submit-button'])) {
    $site = $_POST['site'];
    $theme = $_POST['theme'];
    $id_stud = $_POST['idStudSite'];
    $errors = array();
    if ($site == 0)
        $errors[] = "Сайт должен быть выбран";
    if (empty($theme)) {
        $errors[] = "Тема должна быть выбрана";
    }
    if (empty($id_stud))
        $errors[] = "Id участника должен быть указан";
    if (empty($errors)) {
        if ($site == 2) {
            //открываем карточку пользователя
            $str = "https://www.e-olymp.com/ru/users/" . $id_stud . "/punchcard";
            $htmluser = file_get_contents_curl($str);
            //проверка на то, существует ли такой пользователь
            if ($exis = $htmluser->find('#punch-card', 0)) {
                //находим решенные задачи и информацию о решенной части
                $exis2 = $exis->find('a[style]');
                $i = 0;
                $mas = array();
                foreach ($exis2 as $item) {
                    $title = $item->title;
                    $partssolv = explode(", ", $title);
                    $countpartssolv=count($partssolv);
                    $solved_part[$i] = substr($partssolv[$countpartssolv-1], 0, -1);
                    $href = $item->href;
                    $partshref = explode("/", $href);
                    $solved_numbers[$i] = $partshref[3];
                    $i++;
                }
                //формируем массив для вывода
                $count_solved = 0; //количество решенных задач по всем темам
                if ($exis2)
                    $count_solved = count($solved_numbers);
                $k = 0;
                for ($i = 0; $i < $count_solved; $i++) {
                    for ($j = 0; $j < $_SESSION['counttasks']; $j++) {
                        if ($solved_numbers[$i] == $_SESSION['numbers'][$j]) {
                            $mas['number'][$k] = $solved_numbers[$i];
                            $mas['solvpart'][$k] = $solved_part[$i];
                            $mas['name'][$k] = $_SESSION['names'][$j];
                            $mas['complexitie'][$k] = $_SESSION['complexities'][$j];
                            $k++;
                            break;
                        }
                    }
                }
                $count = $k; //количество решенных задач по данной теме
            } else {
                //если такого пользователя не существует
                $errors[] = "Участника с указанным id на сайте e-olymp не существует";
            }
        }
        else if ($site==1) {
            //открываем карточку пользователя
            $str = "http://acm.timus.ru/author.aspx?id=" . $id_stud . "&locale=ru";
            $htmluser = file_get_html($str);
            //проверка на то, существует ли такой пользователь
            if ($exis = $htmluser->find('.solved_map_box', 0)) {
                //находим номера решенных задач
                $exis2 = $exis->find('td.accepted');
                $i = 0;
                $mas = array();
                foreach ($exis2 as $item) {
                    $solved_numbers[$i] = $exis2[$i]->plaintext;
                    $i++;
                }
                //формируем массив для вывода
                $count_solved = 0; //количество решенных задач по всем темам
                if ($exis2)
                    $count_solved = count($solved_numbers);
                $k = 0;
                for ($i = 0; $i < $count_solved; $i++) {
                    for ($j = 0; $j < $_SESSION['counttasks']; $j++) {
                        if ($solved_numbers[$i] == $_SESSION['numbers'][$j]) {
                            $mas_timus['number'][$k] = $solved_numbers[$i];
                            $mas_timus['name'][$k] = $_SESSION['names'][$j];
                            $mas_timus['complexitie'][$k] = $_SESSION['complexities'][$j];
                            $k++;
                            break;
                        }
                    }
                }
                $count_timus = $k; //количество решенных задач по данной теме
            } else {
                //если такого пользователя не существует
                $errors[] = "Участника с указанным id на сайте timus не существует";
            }
        }
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
        table.output {
            border-collapse: collapse;
        }
        table.output td {
            border: 1px solid black;
            padding: 3px;
        }
        table.output th {
            border: 1px solid black;
            background: rgb(223,240,216);
            padding: 3px;
        }
        select {
            width: 281px;
        }
        div.functionmistake {
            width: 470px;
            border: 1px solid #aa0000;
            background: #F8E4DF;
            padding: 15px;
            border-radius: 9px;
        }
    </style>
    <script src="/js/jquery-2.2.2.js"></script>
    <script src="/js/solvedtasks_js.php"></script>
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
            <h2 class="pagename"><div>Решенные задачи</div></h2>
        </td>
    </tr>
    <tr>
        <td align="center">
            <form method="post" action="solvedtasks.php">
                <table>
                    <tr>
                        <td>Сайт:</td>
                        <td>
                            <select id="id_site" onchange="themesoptions(this.value);" name="site">
                                <option value='0' selected>Выберите сайт</option>
                                <option value='1'>acm.timus</option>
                                <option value='2'>e-olymp</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Тема:</td>
                        <td><!--onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();'-->
                            <select id='id_theme' name="theme" onchange="loadnumbtasks(this.value);">
                                <option value='0' selected>Выберите тему</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Выберите участника:</td>
                        <td>
                            <select id='idstud' name="stud" onchange="checkedstud(this.value);">
                                <option value="0" selected>Выберите участника</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Или введите id участника:</td>
                        <td>
                            <input type="text" size="35" name="idStudSite" id="idPartic" value="<?php echo $id_stud; ?>">
                        </td>
                    </tr>
                </table>
                <div style="margin: 20px;">
                    <input type="submit" name="submit-button" value="Вывести">
                </div>
            </form>
            <?php
            if (!empty($errors)) {
                echo "<div class='functionmistake'>";
                echo "Данные введены неверно. Ошибки:<br>";
                for ($i = 0; $i < count($errors); $i++) {
                    echo $errors[$i] . "<br/>";
                }
                echo "</div>";
            }
            if ($_POST['site']==2) {
                if (!empty($mas)) {
                    echo "<table><tr><td>Участник: " . $id_stud . "</td></tr>";
                    for ($i = 0; $i < $_SESSION['counteolimp']; $i++) {
                        if ($_POST['theme'] == $_SESSION['tageolimp'][$i]) {
                            echo "<tr><td>Тема: " . $_SESSION['maseolimp'][$i] . "</td></tr><tr><td>Сайт: e-olymp.com</td></tr></table><br>";
                            break;
                        }
                    }
                    echo "<table class='output'><tr><th>№ задачи</th><th>Название задачи</th><th>Решенная часть задачи,%</th><th>Сложность задачи,%</th>";
                    for ($i = 0; $i < $count; $i++) {
                        echo "<tr><td align='center'>" . $mas['number'][$i] . "</td><td><a href='https://www.e-olymp.com/ru/problems/".$mas['number'][$i]."'>" . $mas['name'][$i] . "</a></td><td align='center'>" . $mas['solvpart'][$i] . "</td><td align='center'>" . $mas['complexitie'][$i] . "</td></tr>";
                    }
                    echo "</table>";
                } else if ($exis) {
                    echo "Пользователь не решил ни одной задачи по данной теме";
                }
            }
            if ($_POST['site']==1) {
                if (!empty($mas_timus)) {
                    echo "<table><tr><td>Участник: " . $id_stud . "</td></tr>";
                    for ($i = 0; $i < $_SESSION['counttimus']; $i++) {
                        if ($_POST['theme'] == $_SESSION['tagtimus'][$i]) {
                            echo "<tr><td>Тема: " . $_SESSION['mastimus'][$i] . "</td></tr><tr><td>Сайт: acm.timus.ru</td></tr></table><br>";
                            break;
                        }
                    }
                    echo "<table class='output'><tr><th>№ задачи</th><th>Название задачи</th><th>Сложность задачи</th>";
                    for ($i = 0; $i < $count_timus; $i++) {
                        echo "<tr><td align='center'>" . $mas_timus['number'][$i] . "</td><td><a href='http://acm.timus.ru/problem.aspx?space=1&num=".$mas_timus['number'][$i]."&locale=ru'>" . $mas_timus['name'][$i] . "</a></td><td align='center'>" . $mas_timus['complexitie'][$i] . "</td></tr>";
                    }
                    echo "</table>";
                } else if ($exis) {
                    echo "Пользователь не решил ни одной задачи по данной теме";
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>