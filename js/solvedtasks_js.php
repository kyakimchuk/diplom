<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
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
        if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
    function themesoptions(select_index) {
    //ф-я при изменении выпад списка сайтов
        //очищаем поле с id участника
        var studselect = document.getElementById('idstud');
        if (studselect.value!=0) {
            document.getElementById('idPartic').readOnly = false;
            document.getElementById('idPartic').value = "";
        }
        //очищаем список участников
        studselect.options.length = 1;
        //очищаем список тем
        var secondselect = document.getElementById('id_theme');
        secondselect.options.length = 1;
        //если выбран сайт еолимп
        if (select_index == 2) {
            //загружаем список участников (у корорых есть id на сайте еолимп)
            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                    $mas_participants = $connection -> query("SELECT parname,surname,eolimp_id FROM participantACM WHERE user_id=".$_SESSION['user_id']." AND eolimp_id!=''")-> fetchAll();
                    $count_par = count($mas_participants);
                ?>
                var countpar =<?php echo $count_par; ?>;
                studselect.options.length = countpar + 1;
                var p = 0;
                <?php for ($p = 0; $p < $count_par; $p++) : ?>
                    studselect.options[p + 1].text = '<?php echo $mas_participants[$p]['parname'].' '.$mas_participants[$p]['surname']; ?>';
                    studselect.options[p + 1].value = '<?php echo $mas_participants[$p]['eolimp_id']; ?>';
                    p++;
                <?php endfor; ?>
            <?php endif; ?>
            //если еще не загружались темы для еолимпа, то подгрузить их и вывести
            <?php if (empty($_SESSION['counteolimp'])) : ?>
                var xmlhttp = getXmlHttp();
                xmlhttp.open('POST', 'get_themes.php', true); // Открываем асинхронное соединение
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xmlhttp.send("select_index=" + encodeURIComponent(select_index)); // Отправляем POST-запрос
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var infoeolimp = JSON.parse(xmlhttp.responseText);
                        //заполняем второй выпадающий список темами
                        var c = 0;
                        var elem;
                        for (elem in infoeolimp) {
                            c++;
                        }
                        c /= 2;
                        secondselect.options.length = c + 1;
                        var i;
                        for (i = 0; i < c; i++) {
                            secondselect.options[i + 1].text = infoeolimp[i];
                            secondselect.options[i + 1].value = infoeolimp[i + c];
                        }
                    }
                };
            <?php endif; ?>
            //если уже загружались темы для еолимпа, то просто вывести их
            <?php if (!empty($_SESSION['counteolimp'])) : ?>
                //заполняем второй выпадающий список темами
                secondselect.options.length =<?php echo $_SESSION['counteolimp']; ?> +1;
                var j = 1;
                <?php for ($i = 0; $i < $_SESSION['counteolimp']; $i++): ?>
                    secondselect.options[j].text = "<?php echo $_SESSION['maseolimp'][$i];?>";
                    secondselect.options[j].value = "<?php echo $_SESSION['tageolimp'][$i];?>";
                    j++;
                <?php endfor; ?>
            <?php endif; ?>
        }
        //если выбран сайт тимус
        else if (select_index == 1) {
            //загружаем список участников (у корорых есть id на сайте тимус)
            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                    $mas_participants = $connection -> query("SELECT parname,surname,timus_id FROM participantACM WHERE user_id=".$_SESSION['user_id']." AND timus_id!=''")-> fetchAll();
                    $count_par = count($mas_participants);
                ?>
                var countpar = <?php echo $count_par; ?>;
                studselect.options.length = countpar + 1;
                var p = 0;
                <?php for ($p = 0; $p < $count_par; $p++) : ?>
                    studselect.options[p + 1].text = '<?php echo $mas_participants[$p]['parname'].' '.$mas_participants[$p]['surname']; ?>';
                    studselect.options[p + 1].value = '<?php echo $mas_participants[$p]['timus_id']; ?>';
                    p++;
                <?php endfor; ?>
            <?php endif; ?>
            //если еще не загружались темы для тимуса, то подгрузить их и вывести
            <?php if (empty($_SESSION['counttimus'])) : ?>
            var xmlhttp = getXmlHttp();
            xmlhttp.open('POST', 'get_themes.php', true); // Открываем асинхронное соединение
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send("select_index=" + encodeURIComponent(select_index)); // Отправляем POST-запрос
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var infotimus = JSON.parse(xmlhttp.responseText);
                    //заполняем второй выпадающий список темами
                    var c = 0;
                    var elem;
                    for (elem in infotimus) {
                        c++;
                    }
                    c /= 2;
                    secondselect.options.length = c + 1;
                    var i;
                    for (i = 0; i < c; i++) {
                        secondselect.options[i + 1].text = infotimus[i];
                        secondselect.options[i + 1].value = infotimus[i + c];
                    }
                }
            };
            <?php endif; ?>
            //если уже загружались темы для тимуса, то просто вывести их
            <?php if (!empty($_SESSION['counttimus'])) : ?>
            //заполняем второй выпадающий список темами
            secondselect.options.length =<?php echo $_SESSION['counttimus']; ?> +1;
            var j = 1;
            <?php for ($i = 0; $i < $_SESSION['counttimus']; $i++): ?>
            secondselect.options[j].text = "<?php echo $_SESSION['mastimus'][$i];?>";
            secondselect.options[j].value = "<?php echo $_SESSION['tagtimus'][$i];?>";
            j++;
            <?php endfor; ?>
            <?php endif; ?>
        }
    }
    function loadnumbtasks(theme_tag) {
    //ф-я при изменении выпад списка тем
        var firstselect=document.getElementById('id_site');
        if (theme_tag!=0) {
            if (firstselect.value==1) {
                var xmlhttp = getXmlHttp();
                xmlhttp.open('POST', 'get_numb_tasks_timus.php', true); // Открываем асинхронное соединение
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xmlhttp.send("theme_tag=" + encodeURIComponent(theme_tag)); // Отправляем POST-запрос
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    }
                };
            }
            else if (firstselect.value==2) {
                var xmlhttp = getXmlHttp();
                xmlhttp.open('POST', 'get_numb_tasks.php', true); // Открываем асинхронное соединение
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xmlhttp.send("theme_tag=" + encodeURIComponent(theme_tag)); // Отправляем POST-запрос
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    }
                };
            }
        }
    }
    function checkedstud(site_id_stud) {
    //ф-я при изменении выпад списка участников
        if (site_id_stud == 0) {
            document.getElementById('idPartic').readOnly = false;
            document.getElementById('idPartic').value = "";
        }
        else {
            document.getElementById('idPartic').value = site_id_stud;
            document.getElementById('idPartic').readOnly = true;
        }
    }
