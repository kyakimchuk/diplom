<?php
$login = "";
$pass = "";
$rpass = "";
$name = "";
$surname = "";
$email = "";
$errors = array();
$temp = 0;
$connection = new PDO('mysql:host=localhost; port=65535; dbname=diplomDB', 'root', '');

if (isset($_POST["submitbutton"])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $rpass = $_POST['rpass'];
    $name = $_POST['name1'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    if (strlen($login) > 50) {
        $temp = 1;
        $errors[] = "Login length must be no more than 50 symbols";
    }
    $loginlist = $connection->query('SELECT login FROM memberlist');
    while ($row = $loginlist->fetch()) {
        if ($row['login'] == $login) {
            $temp = 1;
            $errors[] = "This login already exists";
        }
    }
    if (strlen($pass) > 50) {
        $temp = 1;
        $errors[] = "Password length must be no more than 50 symbols";
    }
    if ($pass != $rpass) {
        $temp = 1;
        $errors[] = "Password mismatch";
    }
    if (strlen($name) > 50) {
        $temp = 1;
        $errors[] = "Name length must be no more than 50 symbols";
    }
    if (strlen($surname) > 50) {
        $temp = 1;
        $errors[] = "Surname length must be no more than 50 symbols";
    }
    if (strlen($email) > 50) {
        $temp = 1;
        $errors[] = "Email length must be no more than 50 symbols";
    }
    if ($temp == 0) {
        $hashed_pass = md5($pass);
        $sql = "INSERT INTO memberlist ( login, pass, name, surname, email) VALUES (:login,:pass,:name,:surname,:email)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $hashed_pass, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $temp = 2;
    }
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
<?php if ($temp == 2) :
    $login = "";
    $pass = "";
    $rpass = "";
    $name = "";
    $surname = "";
    $email = "";
endif;
?>
<form class="container" method="post" enctype="multipart/form-data">
    <div class="col-md-4 col-md-offset-4">
        <div class="row titleForms">Registration</div>
        <div class="row">
            <table class="tableForms">
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" value="<?php echo $login; ?>" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="pass" value="<?php echo $pass; ?>" required></td>
                </tr>
                <tr>
                    <td>Repeat password:</td>
                    <td><input type="password" name="rpass" value="<?php echo $rpass; ?>" required></td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name1" value="<?php echo $name; ?>" required></td>
                </tr>
                <tr>
                    <td>Surname:</td>
                    <td><input type="text" name="surname" value="<?php echo $surname; ?>" required></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" value="<?php echo $email; ?>" required></td>
                </tr>
            </table>
        </div>
        <div class="col-md-8 col-md-offset-3 buttonsForms">
            <a href="index.php" class="btn btn-danger">Home</a>
            <input class="btn btn-success" type="submit" value="Register" name="submitbutton"/>
        </div>
    </div>
    <br>
    <?php if ($temp == 1) :
        echo "<div class='clear alert alert-danger'><center><br/>";
        echo "The data is entered incorrectly<br/><strong>Errors:</strong><br/>";
        for ($i = 0; $i < count($errors); $i++) {
            echo $errors[$i] . "<br/>";
        }
        echo "</center></div>";
    endif;
    ?>
    <?php if ($temp == 2) :
        echo "<div class='clear alert alert-success'><center><br/>";
        echo "You have successfully registered!";
        echo "</center></div>";
    endif;
    ?>
</form>

</body>
</html>
