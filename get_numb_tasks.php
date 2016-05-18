<?php
require_once 'simple_html_dom.php';
session_start();
unset($_SESSION['counttasks']);
unset($_SESSION['numbers']);
unset($_SESSION['names']);
unset($_SESSION['complexities']);;
$str = "https://www.e-olymp.com/ru/problems?tag=".$_POST["theme_tag"];
    $htmltheme = file_get_html($str);
$tasks = $htmltheme->find('[class="eo-list__item eo-problem-row"]');
$counttasks = count($tasks);
$_SESSION['counttasks']= $counttasks;
for ($i=0; $i<$_SESSION['counttasks']; $i++) {
    $_SESSION['numbers'][$i] = $tasks[$i]->find('[class="eo-problem-row__id eo-problem-row__link_colored"]',0)->plaintext;
    $_SESSION['names'][$i] = $tasks[$i]->find('[class="eo-problem-row__name"]',0)->plaintext;
    $temp = $tasks[$i]->find('[class="eo-problem-complexity-bar__fill"]',0)->style;
    $partcomp = explode(": ", $temp, 2);
    $_SESSION['complexities'][$i] = substr($partcomp[1], 0, -1);
}

if ($exis=$htmltheme->find('ul.pagination',0)) {
    $numpages = $exis->lastchild()->prev_sibling()->plaintext;
    for ($j = 1; $j < $numpages; $j++) {
        $str .= "&page=".$j;
        unset ($htmltheme);
        unset ($tasks);
        unset ($temp);
        unset ($partcomp);
        $htmltheme = file_get_html($str);
        $tasks = $htmltheme->find('[class="eo-list__item eo-problem-row"]');
        $counttasks1 = count($tasks);
        $_SESSION['counttasks'] += $counttasks1;
        $k=0;
        for ($i=$counttasks; $i<$_SESSION['counttasks']; $i++) {
            $_SESSION['numbers'][$i] = $tasks[$k]->find('[class="eo-problem-row__id eo-problem-row__link_colored"]',0)->plaintext;
            $_SESSION['names'][$i] = $tasks[$k]->find('[class="eo-problem-row__name"]',0)->plaintext;
            $temp = $tasks[$k]->find('[class="eo-problem-complexity-bar__fill"]',0)->style;
            $partcomp = explode(": ", $temp, 2);
            $_SESSION['complexities'][$i] = substr($partcomp[1], 0, -1);
            $k++;
        }
        $counttasks=$_SESSION['counttasks'];
    }
}