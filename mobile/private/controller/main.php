<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/homefunctions.php');
if (isset($_POST["action"])) {
    $action = htmlspecialchars($_POST["action"]);
    if ($action == "logout") {
        $_SESSION["auth"] = false;
        unset($_SESSION["id"]);
        session_destroy();
        header("Location: index.php");
    } else if ($action == "updateLatLng" && isset($_POST["lat"]) && isset($_POST["lng"])) {
        $_SESSION["lat"] = htmlspecialchars($_POST["lat"]);
        $_SESSION["lng"] = htmlspecialchars($_POST["lng"]);
    } else if ($action == "updateNear" && isset($_POST["near"])) {
        $_SESSION["near"] = htmlspecialchars($_POST["near"]);
    } else if ($action == "getNewStatusPage") {
        render("inputText");
    } else if ($action == "getNewPhotoPage") {
        render("inputPhoto");
    } else if ($action == "getAddLocationPage" && isset($_POST["from"])) {
        $from = htmlspecialchars($_POST["from"]);
        render("addLocation",array("from"=>$from,"near"=>$_SESSION["near"]));
    }
    exit;
}
if (isset($_GET["action"]) && isset($_SESSION["id"])) {
    $action = htmlspecialchars($_GET["action"]);
    if ($action == "logout") {
        $_SESSION["auth"] = false;
        unset($_SESSION["id"]);
        session_destroy();
        header("Location: index.php");
    } else if ($action == "statusDialog") {
        render("inputText");
    } else if ($action == "photoDialog") {
        render("inputPhoto");
    } else if ($action == "addLocation" && isset($_GET["from"])) {
        $from = htmlspecialchars($_GET["from"]);
        render("addLocation",array("from"=>$from,"near"=>$_SESSION["near"]));     
    } else if ($action == "uploadMobilePhoto") {
        if (isset($_FILES["uploadMobilePhoto"])) {
            echo "file exists";
        } else {
            echo "doesn't exist";
        }
        if (isset($_FILES["uploadMobilePhoto"]) && isset($_POST["expireTime"]) && isset($_POST["postTo"])) {
            echo "here";
            $expireTime = htmlspecialchars($_POST["expireTime"]);
            $postTo = htmlspecialchars($_POST["postTo"]);
            $expireTime = convertExpireTime($expireTime);
            $picId = uploadMobilePhoto($_SESSION["id"],$_FILES["uploadMobilePhoto"]);
            if ($picId != false) {
                $text = "";
                if (isset($_POST["newText"])) {
                    $text = htmlspecialchars($_POST["newText"]);
                }

                controllerAddNewPost($_SESSION["id"],$text,$postTo,null,null,null,null,null,$expireTime,"mobilePhotos/".$picId);
            }
        }
    }
    exit;
}
$_SESSION["near"] = null;
$_SESSION["lat"] = null;
$_SESSION["lng"] = null;
render("main");

?>
