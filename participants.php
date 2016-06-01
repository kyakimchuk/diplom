<?php
require_once 'functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: http://diplom/authorization.php");
    exit;
}
$functs = new funcs();
$parname = "";
$parsurname = "";
$speciality = "";
$group = "";
$course = "";
$idtimus = "";
$ideolimp = "";
$connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
if (isset ($_POST['submitbutton'])) {
    $parname = $_POST['parname'];
    $parsurname = $_POST['parsurname'];
    $speciality = $_POST['speciality'];
    $group = $_POST['group'];
    $course = $_POST['course'];
    $idtimus = $_POST['idtimus'];
    $ideolimp = $_POST['ideolimp'];
    $sql = "INSERT INTO participantACM (parname,surname,speciality,pargroup,course,timus_id,eolimp_id,user_id) VALUES (:parname,:parsurname,:speciality,:pargroup,:course,:idtimus,:ideolimp,:userid)";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':parname', $parname, PDO::PARAM_STR);
    $stmt->bindParam(':parsurname', $parsurname, PDO::PARAM_STR);
    $stmt->bindParam(':speciality', $speciality, PDO::PARAM_STR);
    $stmt->bindParam(':pargroup', $group, PDO::PARAM_STR);
    $stmt->bindParam(':course', $course, PDO::PARAM_STR);
    $stmt->bindParam(':idtimus', $idtimus, PDO::PARAM_STR);
    $stmt->bindParam(':ideolimp', $ideolimp, PDO::PARAM_STR);
    $stmt->bindParam(':userid', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    header("Location: http://diplom/participants.php");
}
//изменить участника
if (isset ($_POST['changebutton'])) {
    /*$sel_id = $_POST['sel_id'];
    $chparname = $_POST['chparname'];
    $chparsurname = $_POST['chparsurname'];
    $chspeciality = $_POST['chspeciality'];
    $chgroup = $_POST['chgroup'];
    $chcourse = $_POST['chcourse'];
    $chidtimus = $_POST['chidtimus'];
    $chideolimp = $_POST['chideolimp'];
    */
    $sql2="UPDATE participantACM set parname = :chparname, surname = :chparsurname, speciality=:chspeciality, pargroup=:chpargroup,
           course=:chcourse, timus_id=:chidtimus, eolimp_id=:chideolimp where id_participant = :sel_id_par";
    $stmt2 = $connection->prepare($sql2);
    $stmt2->bindParam(':chparname', $_POST['chparname'], PDO::PARAM_STR);
    $stmt2->bindParam(':chparsurname', $_POST['chparsurname'], PDO::PARAM_STR);
    $stmt2->bindParam(':chspeciality', $_POST['chspeciality'], PDO::PARAM_STR);
    $stmt2->bindParam(':chpargroup', $_POST['chgroup'], PDO::PARAM_STR);
    $stmt2->bindParam(':chcourse', $_POST['chcourse'], PDO::PARAM_STR);
    $stmt2->bindParam(':chidtimus', $_POST['chidtimus'], PDO::PARAM_STR);
    $stmt2->bindParam(':chideolimp', $_POST['chideolimp'], PDO::PARAM_STR);
    $stmt2->bindParam(':sel_id_par', $_POST['sel_id'], PDO::PARAM_INT);
    $stmt2->execute();
    header("Location: http://diplom/participants.php");
}
//удалить участника
$err_del = "";
if (isset ($_POST['deletebutton'])) {
    $delid = $_POST['delid'];
    if (!is_numeric($delid))
        $delid = 0;
    if ($_SESSION['user_id'] == $connection->query("select user_id from participantACM where id_participant=" . $delid)->fetchColumn()) {
        $connection->query("delete from participantACM where id_participant=" . $delid);
        header("Location: http://diplom/participants.php");
    } else {
        $err_del = "Ошибка удаления. Проверьте правильность указанного id";
    }
}
$mas_participants = $connection->query("SELECT * FROM participantACM WHERE user_id=" . $_SESSION['user_id'])->fetchAll();
$count_par = count($mas_participants);
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
            width: 173px;
        }
        table.participanttable {
            border-collapse: collapse;
        }
        table.participanttable td {
            /*border: 1px solid black;*/
        }
        table.participanttable th {
            /*border: 1px solid black;
            padding: 3px;
            */
            text-align: left;

        }
    </style>
    <script type="text/javascript">
        function getXmlHttp() {
            var xmlhttp;
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }
            if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }
        function changeinfo(id) {
            var xmlhttp = getXmlHttp(); // Создаём объект XMLHTTP
            xmlhttp.open('POST', 'ch_info.php', true); // Открываем асинхронное соединение
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
            xmlhttp.send("id=" + encodeURIComponent(id)); // Отправляем POST-запрос
            xmlhttp.onreadystatechange = function() { // Ждём ответа от сервера
                if (xmlhttp.readyState == 4) { // Ответ пришёл
                    if(xmlhttp.status == 200) { // Сервер вернул код 200 (что хорошо)
                        var infoparticipant = JSON.parse(xmlhttp.responseText); // Преобразуем JSON-строку в массив
                        document.getElementById('chparname').value = infoparticipant["parname"];
                        document.getElementById('chparsurname').value = infoparticipant["surname"];
                        document.getElementById('chspeciality').value = infoparticipant["speciality"];
                        document.getElementById('chgroup').value = infoparticipant["pargroup"];
                        document.getElementById('chcourse').value = infoparticipant["course"];
                        document.getElementById('chidtimus').value = infoparticipant["timus_id"];
                        document.getElementById('chideolimp').value = infoparticipant["eolimp_id"];
                    }
                }
            };
        }
    </script>
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
            <h2 class="pagename"><div>Участники ACM</div></h2>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" width="33%" valign="top">
                        <form method="post" action="participants.php">
                            <p>Добавить участника ACM</p>
                            <table class='participanttable'>
                                <tr>
                                    <td>Имя:</td>
                                    <td><input type="text" name="parname" value="<?php echo $parname; ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Фамилия:</td>
                                    <td><input type="text" name="parsurname" value="<?php echo $parsurname; ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Специальность:</td>
                                    <td><input type="text" name="speciality" value="<?php echo $speciality; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Группа:</td>
                                    <td><input type="text" name="group" value="<?php echo $group; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Курс:</td>
                                    <td><input type="text" name="course" value="<?php echo $course; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Id timus:</td>
                                    <td><input type="text" name="idtimus" value="<?php echo $idtimus; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Id e-olimp:</td>
                                    <td><input type="text" name="ideolimp" value="<?php echo $ideolimp; ?>"></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="submitbutton" value="Добавить">
                        </form>
                    </td>
                    <td align="center" width="33%" valign="top">
                        <form method="post" action="participants.php">
                            <p>Изменить информацию об участнике ACM</p>
                            <table class='participanttable'>
                                <tr>
                                    <td>Id участника:</td>
                                    <td>
                                        <select id="changeid" name="sel_id" onchange=changeinfo(this.value)>
                                            <option value="0" selected>Выберите id участника</option>
                                            <?php for($j=0;$j<$count_par;$j++) {
                                                echo "<option value='".$mas_participants[$j]['id_participant']."'>";
                                                echo $mas_participants[$j]['id_participant'];
                                                echo "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Имя:</td>
                                    <td><input type="text" id="chparname" name="chparname"></td>
                                </tr>
                                <tr>
                                    <td>Фамилия:</td>
                                    <td><input type="text" id="chparsurname" name="chparsurname"></td>
                                </tr>
                                <tr>
                                    <td>Специальность:</td>
                                    <td><input type="text" id="chspeciality" name="chspeciality"></td>
                                </tr>
                                <tr>
                                    <td>Группа:</td>
                                    <td><input type="text" id="chgroup" name="chgroup"></td>
                                </tr>
                                <tr>
                                    <td>Курс:</td>
                                    <td><input type="text" id="chcourse" name="chcourse"></td>
                                </tr>
                                <tr>
                                    <td>Id timus:</td>
                                    <td><input type="text" id="chidtimus" name="chidtimus"></td>
                                </tr>
                                <tr>
                                    <td>Id e-olimp:</td>
                                    <td><input type="text" id="chideolimp" name="chideolimp"></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="changebutton" value="Изменить">
                        </form>
                    </td>
                    <td align="center" width="33%" valign="top">
                        <form method="post" action="participants.php">
                            <p>Удалить участника ACM</p>
                            <table class='participanttable'>
                                <tr>
                                    <td>Id участника:</td>
                                    <td><input type="text" name="delid" value="" required></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="deletebutton" value="Удалить">
                            <?php
                            if (!empty($err_del))
                                echo "<br><br>". $err_del . "<br>";
                            ?>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <br>
            <hr>
            <p>Список участников ACM</p>
            <table class='output'>
                <?php
                echo "<tr><th>Id участника</th><th>Имя</th><th>Фамилия</th><th>Специальность</th><th>Группа</th><th>Курс</th><th>Id timus</th><th>Id e-olimp</th></tr>";
                for ($i = 0; $i < $count_par; $i++) {
                    echo "<tr>";
                    echo "<td>" . $mas_participants[$i]['id_participant'] . "</td>";
                    echo "<td>" . $mas_participants[$i]['parname'] . "</td>";
                    echo "<td>" . $mas_participants[$i]['surname'] . "</td>";
                    echo "<td>";
                    if (!empty($mas_participants[$i]['speciality']))
                        echo $mas_participants[$i]['speciality'];
                    echo "</td>";
                    echo "<td>";
                    if (!empty($mas_participants[$i]['pargroup']))
                        echo $mas_participants[$i]['pargroup'];
                    echo "</td>";
                    echo "<td>";
                    if (!empty($mas_participants[$i]['course']))
                        echo $mas_participants[$i]['course'];
                    echo "</td>";
                    echo "<td>";
                    if (!empty($mas_participants[$i]['timus_id']))
                        echo $mas_participants[$i]['timus_id'];
                    echo "</td>";
                    echo "<td>";
                    if (!empty($mas_participants[$i]['eolimp_id']))
                        echo $mas_participants[$i]['eolimp_id'];
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>