<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: http://regauth/authorization.php");
    exit;
}
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
    header("Location: http://regauth/participants.php");
}
$err_del = "";
if (isset ($_POST['deletebutton'])) {
    $delid = $_POST['delid'];
    if (!is_numeric($delid))
        $delid = 0;
    if ($_SESSION['user_id'] == $connection->query("select user_id from participantACM where id_participant=" . $delid)->fetchColumn()) {
        $connection->query("delete from participantACM where id_participant=" . $delid);
        header("Location: http://regauth/participants.php");
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
    <style>
        table {
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid black;
        }

        th {
            background: #b0e0e6;
        }
    </style>
    <script>
        function filling_info() {

        }
    </script>
</head>
<body>
<form method="post" action="participants.php">
    <table>
        <caption>Добавить участника ACM</caption>
        <tr>
            <th>Имя</th>
            <td><input type="text" name="parname" value="<?php echo $parname; ?>" required></td>
        </tr>
        <tr>
            <th>Фамилия</th>
            <td><input type="text" name="parsurname" value="<?php echo $parsurname; ?>" required></td>
        </tr>
        <tr>
            <th>Специальность</th>
            <td><input type="text" name="speciality" value="<?php echo $speciality; ?>"></td>
        </tr>
        <tr>
            <th>Группа</th>
            <td><input type="text" name="group" value="<?php echo $group; ?>"></td>
        </tr>
        <tr>
            <th>Курс</th>
            <td><input type="text" name="course" value="<?php echo $course; ?>"></td>
        </tr>
        <tr>
            <th>Id timus</th>
            <td><input type="text" name="idtimus" value="<?php echo $idtimus; ?>"></td>
        </tr>
        <tr>
            <th>Id e-olimp</th>
            <td><input type="text" name="ideolimp" value="<?php echo $ideolimp; ?>"></td>
        </tr>
    </table>
    <input type="submit" name="submitbutton" value="Добавить">
</form>
<form method="post" action="participants.php">
    <table>
        <caption>Удалить участника ACM</caption>
        <tr>
            <th>Id участника</th>
            <td><input type="text" name="delid" value="" required></td>
        </tr>
    </table>
    <input type="submit" name="deletebutton" value="Удалить">
    <?php
    if (!empty($err_del))
        echo $err_del . "<br>";
    ?>
</form>
<form method="post" action="participants.php">
    <table>
        <caption>Изменить информацию об участнике ACM</caption>
        <tr>
            <th>Id участника</th>
            <td>
                <select id="changeid" name="sel_id" onchange="filling_info();">
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
            <th>Имя</th>
            <td><input type="text" name="chparname"></td>
        </tr>
        <tr>
            <th>Фамилия</th>
            <td><input type="text" name="chparsurname"></td>
        </tr>
        <tr>
            <th>Специальность</th>
            <td><input type="text" name="chspeciality"></td>
        </tr>
        <tr>
            <th>Группа</th>
            <td><input type="text" name="chgroup"></td>
        </tr>
        <tr>
            <th>Курс</th>
            <td><input type="text" name="chcourse"></td>
        </tr>
        <tr>
            <th>Id timus</th>
            <td><input type="text" name="chidtimus"></td>
        </tr>
        <tr>
            <th>Id e-olimp</th>
            <td><input type="text" name="chideolimp"></td>
        </tr>
    </table>
    <input type="submit" name="changebutton" value="Изменить">
</form>
<table>
    <caption>Список участников ACM</caption>
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
</body>
</html>