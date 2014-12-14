<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
if (isset($_GET["page"])) {
    $page = htmlspecialchars($_GET["page"]);
} else {

    $page = "home";
}
if (isset($_SESSION['id'])) {
    if ($page == "login") {
        $page = "home";
    } else if ($page != "home" && $page != "logout" && $page != "search" && $page != "messages") {
        $page = "home";
    }           
} else if ($page != "create" && $page != "login2" && $page != "create2") {
    $page = "login";
}
$path = '../private/controller/'.$page.'.php';
require_once($path);
?>
