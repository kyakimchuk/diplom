<?php
require_once 'simple_html_dom.php';
require_once 'functions.php';
session_start();
header("Content-Type: text/html; charset=utf-8");
$functs = new funcs();
//if (!isset($_SESSION['counttimus']))  $_SESSION['counttimus']=0;
//if (!isset($_SESSION['counteolimp']))  $_SESSION['counteolimp']=0;
$site=0;
$theme=0;
$id_stud="";
if (isset($_POST['submit-button'])) {
    $site = $_POST['site'];
    $theme = $_POST['theme'];
    $id_stud = $_POST['idStudSite'];
    $errors = array();
    if ($site==0)
        $errors[] = "Сайт должен быть выбран";
    if ($theme==0)
        $errors[] = "Тема должна быть выбрана";
    if (empty($id_stud))
        $errors[] = "Id участника должен быть указан";
    if (empty($errors)) {
        if ($site==2) {
            $str = "https://www.e-olymp.com/ru/users/".$id_stud."/punchcard";
            $htmluser = file_get_contents_curl($str);
            if ($exis = $htmluser->find('#punch-card',0)) {
                $exis2 = $exis->find('a[style]');
                $i=0;
                $mas=array();
                foreach ($exis2 as $item) {
                    $title= $item->title;
                    $partssolv = explode(", ", $title,2);
                    $solved_part[$i]=substr($partssolv[1], 0, -1);
                    $href=$item->href;
                    $partshref = explode("/", $href);
                    $solved_numbers[$i]=$partshref[3];
                    $i++;
                }
                //формируем массив для вывода
                if ($exis2)
                    $count_solved = count($solved_numbers);
                else
                    $count_solved=0;
                $k=0;
                for ($i=0; $i<$count_solved; $i++) {
                    for ($j=0; $j<$_SESSION['counttasks']; $j++) {
                        if ($solved_numbers[$i]==$_SESSION['numbers'][$j]) {
                            $mas['number'][$k]=$solved_numbers[$i];
                            $mas['solvpart'][$k]=$solved_part[$i];
                            $mas['name'][$k]=$_SESSION['names'][$j];
                            $mas['complexitie'][$k]=$_SESSION['complexities'][$j];
                            $k++;
                            break;
                        }
                    }
                }
                $count = $k;
            }
            else {
                $errors[]= "Участника с указанным id на сайте e-olimp не существует";
            }
        }
    }
    /*echo $_SESSION['counttasks']."<br>";
    for ($i=0; $i<$_SESSION['counttasks']; $i++) {
        echo $_SESSION['complexities'][$i]."<br>";
    }*/
    //unset($_SESSION['counteolimp']);
    /*unset($_SESSION['counttasks']);
    unset($_SESSION['numbers']);
    unset($_SESSION['names']);
    unset($_SESSION['complexities']);
    unset($_POST['submit-button']);
    unset($_POST['site']);
    unset($_POST['theme']);
    unset($_POST['idStudSite']);*/
}
?>
<html>
<head>
    <meta charset='utf-8'>
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
    <script src="/js/jquery-2.2.2.js"></script>
    <script src="/js/solvedtasks_js.php"></script>
</head>
<body>
<form method="post" action="solvedtasks.php">
    <select id="id_site" onchange="themesoptions(this.value);" name="site">
         <option value='0' selected>Выберите сайт</option>
         <option value='1'>acm.timus</option>;
         <option value='2'>e-olimp</option>;
    </select>
    <select id='id_theme' name="theme" onchange="loadnumbtasks(this.value);">
        <option value="0" selected>Выберите тему</option>
    </select><br><br>
    <select id='idstud' name="stud" onchange="">
        <option value="0" selected>Выберите участника</option>
    </select>
    <br><br>
    Или введите id участника на выбранном сайте:
    <input type="text" size="20" name="idStudSite" value="<?php echo $id_stud;?>"><br><br>
    <input type="submit" name="submit-button" value="Вывести">
</form>
<?php
if (!empty($errors)) {
    echo "Ошибка!<br>";
    for ($i = 0; $i < count($errors); $i++) {
        echo $errors[$i] . "<br/>";
    }
}
if (!empty($mas)) {
    echo "<center><h3>".$id_stud."</h3></center><br>";
    echo "<center><table><caption>Решенные задачи</caption><tr><th>№ задачи</th><th>Название задачи</th><th>Решенная часть задачи,%</th><th>Сложность задачи,%</th>";
    for ($i=0; $i<$count; $i++) {
         echo "<tr><td>".$mas['number'][$i]."</td><td>".$mas['name'][$i]."</td><td>".$mas['solvpart'][$i]."</td><td>".$mas['complexitie'][$i]."</td></tr>";
    }
    echo "</table></center>";
}
else if ($exis) {
    echo "<center>Пользователь не решил ни одной задачи по данной теме</center>";
}

/*
for ($i=0; $i<$_SESSION['counttasks']; $i++) {
    echo $_SESSION['complexities'][$i]."<br>";
}*/
?>
</body>
</html>