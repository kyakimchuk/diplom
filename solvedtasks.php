<?php
require_once 'simple_html_dom.php';
session_start();
if (!isset($_SESSION['counttimus']))  $_SESSION['counttimus']=0;
if (!isset($_SESSION['counteolimp']))  $_SESSION['counteolimp']=0;
//unset($_SESSION['counteolimp']);
?>
<html>
<head>
    <meta charset='utf-8'>
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
    </script>
</head>
<body>

<form method="post" action="solvedtasks.php">
    <select id="id_site" onchange="themesoptions(this.value);" name="site">
        <option value="0" selected>Выберите сайт</option>
        <option value="1">acm.timus</option>
        <option value="2">e-olimp</option>
    </select>
    <select id='id_theme' name="theme">
        <option value="0" selected>Выберите тему</option>
    </select>
    <br><br>
    <input type="text" size="40" name="idStudSite"><br><br>
    <input type="submit" name="submit-button">
</form>
</body>
</html>