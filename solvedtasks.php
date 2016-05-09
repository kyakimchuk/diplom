<?php
require_once 'simple_html_dom.php';
session_start();
if (!isset($_SESSION['counter'])) $_SESSION['counter']=0;
unset($_SESSION['counter']);
session_destroy();
?>
<html>
<head>
    <meta charset='utf-8'>
    <script>
        function themesoptions() {
            var ind = document.getElementById('id_site').selectedIndex;
            if (ind == 1) {
                <?php if (!isset($_SESSION['counter'])) : ?>
                alert('Подгружаем данные для тимуса');
                <?php endif;?>
                alert ('выводим уже имеющиеся данные');
            }
            if (ind == 0) {
                secondselect.options.length = 1;
            }
        }
    </script>
</head>
<body>

<form method="post" action="solvedtasks.php">
    <select id="id_site" onchange="themesoptions();" name="site">
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