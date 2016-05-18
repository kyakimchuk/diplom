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
            if ($exis = $htmluser->find('#punch-card a[style]')) {
                $i=0;
                $mas=array();
                foreach ($exis as $item) {
                    $title= $item->title;
                    $partssolv = explode(", ", $title,2);
                    $solved_part[$i]=substr($partssolv[1], 0, -1);
                    $href=$item->href;
                    $partshref = explode("/", $href);
                    $solved_numbers[$i]=$partshref[3];
                    $i++;
                }
                //формируем массив для вывода
                $count_solved = count($solved_numbers);
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
    <script>
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
        function themesoptions(select_index) {
            if (select_index == 2) {
                <?php if (empty($_SESSION['counteolimp'])) : ?>
                var xmlhttp = getXmlHttp();
                xmlhttp.open('POST', 'get_themes.php', true); // Открываем асинхронное соединение
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xmlhttp.send("select_index=" + encodeURIComponent(select_index)); // Отправляем POST-запрос
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var infoeolimp = JSON.parse(xmlhttp.responseText);
                        //заполняем второй выпадающий список темами
                        var secondselect = document.getElementById('id_theme');
                        var c=0;
                        var elem;
                        for (elem in infoeolimp) {
                            c++;
                        }
                        c/=2;
                        secondselect.options.length = 1;
                        secondselect.options.length = c+1;
                        var i;
                        for (i=0; i<c; i++) {
                            secondselect.options[i+1].text = infoeolimp[i];
                            secondselect.options[i+1].value = infoeolimp[i+c];
                        }
                    }
                };
                <?php endif; ?>
                <?php if(!empty($_SESSION['counteolimp'])) : ?>
                //заполняем второй выпадающий список темами
                var secondselect = document.getElementById('id_theme');
                secondselect.options.length = 1;
                secondselect.options.length =  <?php echo $_SESSION['counteolimp'];?> + 1;
                var j = 1;
                <?php
                    for ($i=0;$i<$_SESSION['counteolimp'];$i++):
                ?>
                secondselect.options[j].text = "<?php echo $_SESSION['maseolimp'][$i];?>";
                secondselect.options[j].value = "<?php echo $_SESSION['tageolimp'][$i];?>";
                j++;
                <?php endfor; endif;?>
            }
        }
        function loadnumbtasks(theme_tag) {
            var xmlhttp = getXmlHttp();
            xmlhttp.open('POST', 'get_numb_tasks.php', true); // Открываем асинхронное соединение
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("theme_tag=" + encodeURIComponent(theme_tag)); // Отправляем POST-запрос
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //var infoeolimp = JSON.parse(xmlhttp.responseText);
                }
            };
        }
    </script>
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
    </select>
    <br><br>
    Введите id участника на выбранном сайте:
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
    //echo $count_solved;
    echo "<center><h3>".$id_stud."</h3></center><br>";
    echo "<center><table><caption>Решенные задачи</caption><tr><th>№ задачи</th><th>Название задачи</th><th>Решенная часть задачи,%</th><th>Сложность задачи,%</th>";
    for ($i=0; $i<$count; $i++) {
         echo "<tr><td>".$mas['number'][$i]."</td><td>".$mas['name'][$i]."</td><td>".$mas['solvpart'][$i]."</td><td>".$mas['complexitie'][$i]."</td></tr>";
    }
    echo "</table></center>";
}

/*
for ($i=0; $i<$_SESSION['counttasks']; $i++) {
    echo $_SESSION['complexities'][$i]."<br>";
}*/
?>
</body>
</html>