<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();

/*
if (isset($_GET["page"])) {
    $page = htmlspecialchars($_GET["page"]);
} else {
    $page = "home";
}
if (isset($_SESSION['id'])) {
    if ($page == "login") {
        $page = "home";
    } else if ($page != "home" && $page != "logout" && $page != "search" && $page != "messages" && $page != "profile") {
        $page = "home";
    }           
} else if ($page != "create" && $page != "login2" && $page != "create2") {
    $page = "login";
}*/

if (isset($_SESSION['id'])) {
    if (isset($_POST["page"]) && isset($_POST["pass"]) && htmlspecialchars($_POST["pass"])) {
        $postPage = htmlspecialchars($_POST["page"]);
        if ($postPage == "friendsFeed") {
            $page = "home";
        } else if ($postPage == "profile") {
            $page = "profile";
        } else if ($postPage == "messages") {
            $page = "messages";
        } else if ($postPage == "search") {
            $page = "search";
        } else if ($postPage == "main") {
            $page = "main";
        } else {
            $page = "home";
        }
    } else if (isset($_GET["page"])) {
        $getPage = htmlspecialchars($_GET["page"]);
        if ($getPage == "friendsFeed") {
            $page = "home";
        } else if ($getPage == "profile") {
            $page = "profile";
        } else if ($getPage == "messages") {
            $page = "messages";
        } else if ($getPage == "search") {
            $page = "search";
        } else if ($getPage == "main") {
            $page = "main";
        } else {
            $page = "home";
        }
    } else {
        $page = "home";
    }
} else {
    $page = "login";
}
$path = '../private/controller/'.$page.'.php';
require_once($path);
?>
