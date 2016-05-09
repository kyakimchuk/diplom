<?php
require_once 'functions.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: http://diplom/profile.php");
    exit;
}
$functs = new funcs();
$login = "";
$pass = "";
$error = "";
if (isset($_POST["submitbutton"])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];

    if ($res = $functs->user_exist($login, $pass)) {
        $functs->login($res);
        $error = 2;
    } else
        $error = 1;
}
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<form class="container" method="post">
    <div class="col-sm-4 centered">
        <div class="row titleForms">Enter</div>
        <div class="row">
            <table class="tableForms">
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" value="" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="pass" value="" required></td>
                </tr>
            </table>
            <div class="buttonsForms">
                <a class="col-xs-4 btn btn-danger" href="index.php">Home</a>
                <input class="col-xs-4 btn btn-success" type="submit" value="Login" name="submitbutton"/>
            </div>
        </div>
    </div>
    <?php
    if ($error == 1) {
        echo "<br><div class='clear alert alert-danger'><center>Login or password entered incorrect</center></div>";
    }
    if ($error == 2) {
        echo "<br><div class='clear alert alert-success'><center>You have successfully authorized!</center></div>";
    }
    ?>

</form>
</body>
</html>
