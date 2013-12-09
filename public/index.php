<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
if (isset($_SESSION['id'])) {
    if (isset($_GET["page"])) {
        $page = htmlspecialchars($_GET["page"]);
        if ($page == "login") {
            $page = "home";
        } else if ($page != "home" && $page != "logout") {
            $page = "home";
        }           
    } else {
        $page = "home";
    }
} else if (isset($_GET["page"]) && htmlspecialchars($_GET["page"]) == "create") {
    $page = "create";
} else {
    $page = "login";
}
$path = '../private/controller/'.$page.'.php';
require_once($path);
?>
