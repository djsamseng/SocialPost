<?php
require_once('includes/helper.php');
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $results = validLogin($email,$password);
    if ($results) {
        require_once('../private/model/mongodatabase.php');
        $info = login($email,$password);
        if (isset($info) && $info["auth"]) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $info["id"];
            $_SESSION['firstname']=$info["firstname"];
            $_SESSION['lastname'] = $info["lastname"];
            header("Location: index.php");
        } else {
            render('login2',array('error'=>'Incorrect email and password'));
        }
    } else {
        render('login2',array('error'=>'Invalid email/password entry'));
    }
} else {
    render('login2');
}
?>
