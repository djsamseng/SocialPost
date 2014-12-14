<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
    $loginEmail = htmlspecialchars($_POST["loginEmail"]);
    $loginPassword = htmlspecialchars($_POST["loginPassword"]);
    $results = validLogin($loginEmail,$loginPassword);
    if ($results) {
        $info = login($loginEmail,$loginPassword);
        if (isset($info) && $info["auth"]) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $info["id"];
            $_SESSION['firstname']=$info["firstname"];
            $_SESSION['lastname'] = $info["lastname"];
            echo "success";
        } else {
            //render('login',array('er'=>'Error'));
            echo "failure";
        }
    } else {
        //render('login',array('er'=>'invalid'));
        echo "failure";
    }
} else {
    render('login',array());
}



?>
