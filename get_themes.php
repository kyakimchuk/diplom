<?php
require_once 'simple_html_dom.php';
session_start();
if ($_POST["select_index"]==2) {
    $htmleolimp = file_get_html("http://www.e-olymp.com/ru/problems");
    $themes_eolimp = $htmleolimp->find('.modal-dialog .modal-content .eo-list a');
    $i = 0;
    $_SESSION['counteolimp'] = count($themes_eolimp);
    foreach ($themes_eolimp as $theme_eolimp) {
        $_SESSION['maseolimp'][$i] = $theme_eolimp->plaintext;
        $part_tag_eolimp = explode("tag=", $theme_eolimp->href, 2);
        $_SESSION['tageolimp'][$i] = $part_tag_eolimp[1];
        $i++;
    }
    for ($j=0; $j< $_SESSION['counteolimp']; $j++) {
        $mas_eolimp [$j] = $_SESSION['maseolimp'][$j];
        $mas_eolimp [$j+$_SESSION['counteolimp']] = $_SESSION['tageolimp'][$j];
    }
    echo json_encode($mas_eolimp);
}
?>