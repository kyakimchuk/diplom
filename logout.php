<?php
require_once 'functions.php';
$functs = new funcs();
$functs->logout();
header("Location: index.php");
?>