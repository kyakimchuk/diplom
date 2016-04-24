<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: http://regauth/authorization.php");
    exit;
}
?>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <a href="participants.php">Участники ACM</a>
</body>
</html>