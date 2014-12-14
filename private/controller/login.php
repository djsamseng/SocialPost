<?php
//require_once('includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
//require_once('../private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
//require_once('../private/model/feeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $results = validLogin($email,$password);
    if ($results) {
        $info = login($email,$password);
        if (isset($info) && $info["auth"]) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $info["id"];
            $_SESSION['firstname']=$info["firstname"];
            $_SESSION['lastname'] = $info["lastname"];
            header("Location: index.php");
        } else {
            header("Location: index.php?page=login&er=".$info["er"]);
            exit;
        }
    } else {
        header("location: index.php?page=login&er=invalid");
        exit;
    }
} else {
    render('login',array('posts'=>getWorldFeed()));
}
?>
