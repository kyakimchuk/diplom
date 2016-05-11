<?php
$idpar=$_POST["id"];
$connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');
$result = $connection->query("SELECT * FROM participantACM where id_participant='$idpar'")->fetch();
echo json_encode($result);
?>