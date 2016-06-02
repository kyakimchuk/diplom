<?php
require_once 'functions.php';
require_once 'simple_html_dom.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
$functs = new funcs();
$connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
//загружаем список участников (у корорых есть id на сайте тимус)
$count_par=0;
if (isset($_SESSION['user_id'])) {
    $mas_participants = $connection->query("SELECT parname,surname,timus_id FROM participantACM WHERE user_id=" . $_SESSION['user_id'] . " AND timus_id!=''")->fetchAll();
    $count_par = count($mas_participants);
}
$numbtask = "";
$count_sel_par=0;
$mas_rating=array();
if (isset($_POST['submit-button'])) {
    $numbtask = $_POST['numbtask'];
    $errors = array();
    if (!is_numeric($numbtask)) {
        $errors[]="Номер задачи должен состоять только из цифр";
    }
    else if ($numbtask<1000 || $numbtask>2077) {
        $errors[]="Задачи с таким номером на сайте acm.timus.ru не существует";
    }
    if (empty($errors)) {
        $count_sel_par = count($_POST['participants']);
        for ($i=0;$i<$count_sel_par;$i++) {
            $str = "http://acm.timus.ru/status.aspx?space=1&num=".$numbtask."&author=" . $_POST['participants'][$i] . "&locale=ru";
            $htmltask = file_get_contents_curl($str);
            $mas_rating[$i]['id']=$_POST['participants'][$i];
            $exis = $htmltask->find('table.status tr[class!=header]');
            $count_exis = count($exis);
            if ($count_exis==0) {
                $mas_rating[$i]['ac']="Нет";
                $mas_rating[$i]['time']="";
                $mas_rating[$i]['mem']="";
                $mas_rating[$i]['tries']=0;
            }
            else {
                $k=1;
                $tries=0;
                for ($j=$count_exis-1; $j>=0; $j--) {
                    if (($exis[$j]->find('td', 5)->plaintext)=='Accepted') {
                        $mas_rating[$i]['ac']='Да';
                        $mas_rating[$i]['tries']=$k;
                        $mas_rating[$i]['time']=$exis[$j]->find('td', 7)->plaintext;
                        $mas_rating[$i]['mem']=str_replace(" ","",substr($exis[$j]->find('td', 8)->plaintext, 0, -5));
                        break;
                    }
                    $k++;
                }
                if (empty($mas_rating[$i]['ac'])) {
                    $mas_rating[$i]['ac']='Нет';
                    $mas_rating[$i]['tries']=$count_exis;
                    $mas_rating[$i]['time']="";
                    $mas_rating[$i]['mem']="";
                }
            }
        }
        $data_tries=array();
        foreach($mas_rating as $key=>$arr){
            $data_tries[$key]=$arr['tries'];
        }
        $data_time=array();
        foreach($mas_rating as $key=>$arr){
            $data_time[$key]=$arr['time'];
        }
        $data_ac=array();
        foreach($mas_rating as $key=>$arr){
            $data_ac[$key]=$arr['ac'];
        }
        $data_mem=array();
        foreach($mas_rating as $key=>$arr){
            $data_mem[$key]=$arr['mem'];
        }
        array_multisort($data_ac, $data_tries, $data_time, $data_mem, $mas_rating);
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
    <!--<script src="/js/jquery-2.2.2.js"></script>
    <script src="/js/solvedtasks_js.php"></script>-->
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
            <h2 class="pagename"><div>Рейтинг по задаче</div></h2>
        </td>
    </tr>
    <tr>
        <td align="center">
            <form method="post" action="taskrating.php">
                <table>
                    <tr>
                        <td>Введите номер задачи:</td>
                        <td>
                            <input type="text" size="35" name="numbtask" value="<?php echo $numbtask; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Выберите участников:</td>
                        <td>
                            <select name="participants[]" multiple required>
                                <?php
                                if (isset($_SESSION['user_id'])) {
                                    for($i=0; $i<$count_par; $i++) {
                                        echo "<option value='".$mas_participants[$i]['timus_id']."'>".$mas_participants[$i]['parname']." ".$mas_participants[$i]['surname']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php if (!isset($_SESSION['user_id'])) : ?>
                        <tr>
                            <td align="center" style="color: red; padding: 5px 0px 0px 0px;" colspan="2">Авторизуйтесь, чтобы выбирать участников!</td>
                        </tr>
                    <?php endif;?>
                </table>
                <div style="margin: 20px;">
                    <input type="submit" name="submit-button" value="Вывести рейтинг">
                </div>
            </form>
            <?php
            if (empty($errors) && !empty($mas_rating)) {
                for ($i = 0; $i < $count_sel_par; $i++) {
                    for ($j=0; $j<$count_par; $j++) {
                        if ($mas_rating[$i]['id']==$mas_participants[$j]['timus_id']) {
                            $mas_rating[$i]['parname'] = $mas_participants[$j]['parname'];
                            $mas_rating[$i]['surname'] = $mas_participants[$j]['surname'];
                            break;
                        }
                    }
                    if ($mas_rating[$i]['ac']=='Нет') {
                        $mas_rating[$i]['time']='-';
                        $mas_rating[$i]['mem']='-';
                    }
                }
                echo "<table class='output'><tr><th>Место</th><th>Timus-id</th><th>Имя</th><th>Фамилия</th><th>Задача сдана</th><th>Кол-во попыток<br>до сдачи</th><th>Время,<br>с</th><th>Память,<br>КБ</th></tr>";
                for ($i = 0; $i < $count_sel_par; $i++) {
                    $y=$i+1;
                    echo "<tr><td align='center'>".$y."</td><td>".$mas_rating[$i]['id'] . "</td><td>" .$mas_rating[$i]['parname'] . "</td><td>" .$mas_rating[$i]['surname'] . "</td><td align='center'>" . $mas_rating[$i]['ac'] . "</td><td align='center'>" . $mas_rating[$i]['tries'] . "</td><td align='center'>" . $mas_rating[$i]['time'] . "</td><td align='center'>" . $mas_rating[$i]['mem'] . "</td></tr>";
                }
                echo "</table>";
            }
            if (!empty($errors)) {
                echo "<div class='functionmistake'>";
                echo "Ошибка! ";
                for ($i = 0; $i < count($errors); $i++) {
                    echo $errors[$i] . "<br/>";
                }
                echo "</div>";
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>