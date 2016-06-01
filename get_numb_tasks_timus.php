<?php
require_once 'simple_html_dom.php';
session_start();
unset($_SESSION['counttasks']);
unset($_SESSION['numbers']);
unset($_SESSION['names']);
unset($_SESSION['complexities']);
$str = "http://acm.timus.ru/problemset.aspx?space=1&tag=" . $_POST["theme_tag"]. "&skipac=False&sort=id&locale=ru";
$htmltheme = file_get_html($str);
$tasks = $htmltheme->find('.problemset tr.content');
$counttasks = count($tasks)-1;
$_SESSION['counttasks'] = $counttasks;
for ($i = 1; $i <= $_SESSION['counttasks']; $i++) {
    $_SESSION['numbers'][$i-1] = $tasks[$i]->find('td', 1)->plaintext;
    $_SESSION['names'][$i-1] = $tasks[$i]->find('td', 2)->plaintext;
    $_SESSION['complexities'][$i-1] = $tasks[$i]->find('td', 5)->plaintext;
}
