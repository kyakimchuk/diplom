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
    $add_temp=0;
    $add_errors=array();
    $parname = $_POST['parname'];
    $parsurname = $_POST['parsurname'];
    $speciality = $_POST['speciality'];
    $group = $_POST['group'];
    $course = $_POST['course'];
    $idtimus = $_POST['idtimus'];
    $ideolimp = $_POST['ideolimp'];
    if (strlen($parname) > 50) {
        $add_temp = 1;
        $add_errors[] = "Длина имени должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $parname)) {
        $add_temp = 1;
        $add_errors[] = "Имя может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($parsurname) > 50) {
        $add_temp = 1;
        $add_errors[] = "Длина фамилии должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $parsurname)) {
        $add_temp = 1;
        $add_errors[] = "Фамилия может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($speciality) > 50) {
        $add_temp = 1;
        $add_errors[] = "Длина специальности должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'\ -]*$|', $speciality)) {
        $add_temp = 1;
        $add_errors[] = "Специальность может содержать только русские, украинские буквы, дефисы, апострофы и пробелы";
    }
    if (strlen($group) > 10) {
        $add_temp = 1;
        $add_errors[] = "Длина группы должна быть не более чем 10 символов";
    }
    if(!preg_match('|^[0-9АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $group)) {
        $add_temp = 1;
        $add_errors[] = "Группа содержит недопустимые символы";
    }
    if (strlen($course) > 1 || !preg_match('|^[0-9]*$|', $course)) {
        $add_temp = 1;
        $add_errors[] = "Курс должен быть представлен 1 цифрой";
    }
    if (strlen($idtimus) > 10) {
        $add_temp = 1;
        $add_errors[] = "Длина timus-id должна быть не более чем 10 цифр";
    }
    if (!preg_match('|^[0-9]*$|', $idtimus)) {
        $add_temp = 1;
        $add_errors[] = "Timus-id должен содержать только цифры";
    }
    if (strlen($ideolimp) > 30) {
        $add_temp = 1;
        $add_errors[] = "Длина e-olymp-id должна быть не более чем 30 символов";
    }
    if(!preg_match('|^[A-Z0-9_-]*$|i', $ideolimp)) {
        $add_temp = 1;
        $add_errors[] = "E-olymp-id может содержать только английские буквы, цифры, знаки подчеркивания и дефисы";
    }
    if ($add_temp==0) {
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
}
//изменить участника
if (isset ($_POST['changebutton']))  {
    $change_temp=0;
    $change_errors=array();
    if (strlen($_POST['chparname']) > 50) {
        $change_temp = 1;
        $change_errors[] = "Длина имени должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $_POST['chparname'])) {
        $change_temp = 1;
        $change_errors[] = "Имя может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($_POST['chparsurname']) > 50) {
        $change_temp = 1;
        $change_errors[] = "Длина фамилии должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $_POST['chparsurname'])) {
        $change_temp = 1;
        $change_errors[] = "Фамилия может содержать только русские, украинские буквы, дефисы и апострофы";
    }
    if (strlen($_POST['chspeciality']) > 50) {
        $change_temp = 1;
        $change_errors[] = "Длина специальности должна быть не более чем 50 символов";
    }
    if(!preg_match('|^[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'\ -]*$|', $_POST['chspeciality'])) {
        $change_temp = 1;
        $change_errors[] = "Специальность может содержать только русские, украинские буквы, дефисы, апострофы и пробелы";
    }
    if (strlen($_POST['chgroup']) > 10) {
        $change_temp = 1;
        $change_errors[] = "Длина группы должна быть не более чем 10 символов";
    }
    if(!preg_match('|^[0-9АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяІіЇїЄєҐґ\'-]*$|', $_POST['chgroup'])) {
        $change_temp = 1;
        $change_errors[] = "Группа содержит недопустимые символы";
    }
    if (strlen($_POST['chcourse']) > 1 || !preg_match('|^[0-9]*$|', $_POST['chcourse'])) {
        $change_temp = 1;
        $change_errors[] = "Курс должен быть представлен 1 цифрой";
    }
    if (strlen($_POST['chidtimus']) > 10) {
        $change_temp = 1;
        $change_errors[] = "Длина timus-id должна быть не более чем 10 цифр";
    }
    if (!preg_match('|^[0-9]*$|', $_POST['chidtimus'])) {
        $change_temp = 1;
        $change_errors[] = "Timus-id должен содержать только цифры";
    }
    if (strlen($_POST['chideolimp']) > 30) {
        $change_temp = 1;
        $change_errors[] = "Длина e-olymp-id должна быть не более чем 30 символов";
    }
    if(!preg_match('|^[A-Z0-9_-]*$|i', $_POST['chideolimp'])) {
        $change_temp = 1;
        $change_errors[] = "E-olymp-id может содержать только английские буквы, цифры, знаки подчеркивания и дефисы";
    }
    if ($change_temp==0) {
        $sql2 = "UPDATE participantACM set parname = :chparname, surname = :chparsurname, speciality=:chspeciality, pargroup=:chpargroup,
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
        table.participanttable th {
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
                                    <td>Id e-olymp:</td>
                                    <td><input type="text" name="ideolimp" value="<?php echo $ideolimp; ?>"></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="submitbutton" value="Добавить">
                        </form>
                        <?php if ($add_temp == 1) {
                            echo "Данные введены неверно. Ошибки:<br/>";
                            for ($i = 0; $i < count($add_errors); $i++) {
                                echo $add_errors[$i] . "<br/>";
                            }
                        }
                        ?>
                    </td>
                    <td align="center" width="33%" valign="top">
                        <form method="post" action="participants.php">
                            <p>Изменить информацию об участнике ACM</p>
                            <table class='participanttable'>
                                <tr>
                                    <td>Id участника:</td>
                                    <td>
                                        <select id="changeid" name="sel_id" onchange=changeinfo(this.value) required>
                                            <option value="" selected>Выберите id участника</option>
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
                                    <td><input type="text" id="chparname" name="chparname" required></td>
                                </tr>
                                <tr>
                                    <td>Фамилия:</td>
                                    <td><input type="text" id="chparsurname" name="chparsurname" required></td>
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
                                    <td>Id e-olymp:</td>
                                    <td><input type="text" id="chideolimp" name="chideolimp"></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="changebutton" value="Изменить">
                        </form>
                        <?php if ($change_temp == 1) {
                            echo "Данные введены неверно. Ошибки:<br/>";
                            for ($i = 0; $i < count($change_errors); $i++) {
                                echo $change_errors[$i] . "<br/>";
                            }
                        }
                        ?>
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
                echo "<tr><th>Id участника</th><th>Имя</th><th>Фамилия</th><th>Специальность</th><th>Группа</th><th>Курс</th><th>Id timus</th><th>Id e-olymp</th></tr>";
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