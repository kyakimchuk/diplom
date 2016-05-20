<?php
    session_start();
    $connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
?>
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
        var studselect = document.getElementById('idstud');
        studselect.options.length = 1;
    <?php if (isset($_SESSION['user_id'])) : ?>
        <?php   $mas_participants = $connection->query("SELECT * FROM participantACM WHERE user_id=" . $_SESSION['user_id']." AND eolimp_id!=''")->fetchAll();
                $count_par = count($mas_participants);
        ?>
            var countpar=<?php echo $count_par; ?>;
            alert (countpar);
            //studselect.options.length = 1;
     <?php endif; ?>
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
    else if (select_index == 1) {

    }
    else if (select_index == 0) {
        var secondselect = document.getElementById('id_theme');
        secondselect.options.length = 1;
        var studselect = document.getElementById('idstud');
        studselect.options.length = 1;
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