<?php
require_once('includes/helper.php');
if (isset($_SESSION["id"]) && $_SESSION["id"] > 0 && isset($_SESSION["auth"]) &&$_SESSION["auth"] == true) {
    render("home");
} else {
    if (isset($_POST["nemail"]) && isset($_POST["npassword"]) && isset($_POST["nfirstname"]) && isset($_POST["nlastname"]) && isset($_GET["page"]) && htmlspecialchars($_GET["page"]) == "create") {
        $nemail = htmlspecialchars($_POST["nemail"]);
        $npassword = htmlspecialchars($_POST["npassword"]);
        $nfirstname = htmlspecialchars($_POST["nfirstname"]);
        $nlastname = htmlspecialchars($_POST["nlastname"]);
        $zip = htmlspecialchars($_POST["zipcode"]);
        if (strlen($zip) > 0) {
            header("Location: index.php?page=create2");
        }
        if (validLogin($nemail,$npassword)) {
            require_once('../private/model/mongodatabase.php');
            $info = create($nemail,$npassword,$nfirstname,$nlastname);
            if (isset($info) && $info["auth"]) {
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $info["id"];
                $_SESSION['firstname']=$info["firstname"];
                $_SESSION['lastname'] = $info["lastname"];
                header("Location: index.php");
            } else {
                header("Location: index.php?er=emailtaken");
            }
        } else {
            header("Location:index.php?er=emailtaken");//FIX THIS STUFF LATER
        }
    } else {
        render('login');
    }
}
?>
