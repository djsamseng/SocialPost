<?php
if (isset($_POST["id"]) && isset($_POST["type"]) && isset($_POST["first"]) && isset($_POST["last"])) {
    $id = htmlspecialchars($_POST["id"]); //need to encode / decode
    $feedtype = htmlspecialchars($_POST["type"]);
    $firstpostdate = htmlspecialchars($_POST["first"]);
    $lastpostdate = htmlspecialchars($_POST["last"]);
    if (isset($_POST["loadbottom"])) {
        $loadBottom = htmlspecialchars($_POST["loadbottom"]);
    } else {
        $loadBottom = false;
    }
    if (isset($_POST["newload"])) {
        $newLoad = htmlspecialchars($_POST["newload"]);
    } else {
        $newLoad = true;
    }
    if (isset($_POST["currentnum"])) {
        $currentNum = htmlspecialchars($_POST["currentnum"]);
    } else {
        $currentNum = 0;
    }
    if (isset($_POST["last"])) {
        $last = htmlspecialchars($_POST["last"]);
    } else {
        $last = null;
    }
    if (isset($_POST["first"])) {
        $first = htmlspecialchars($_POST["first"]);
    }
    if (isset($_POST["mylat"]) && isset($_POST["mylng"])) {
        $myLat = htmlspecialchars($_POST["mylat"]);
        $myLng = htmlspecialchars($_POST["mylng"]);
    } else {
        $myLat = null;
        $myLng = null;
    }
} else {
    exit;
}
if ($feedtype != "friends" && $feedtype != "world") {
    exit;
}
if ($newLoad == "false") {
    $newLoad = false;
}
if ($newLoad == "true") {
    $newLoad = true;
}
if ($loadBottom == "false") {
    $loadBottom = false;
}
if ($loadBottom == "true") {
    $loadBottom = true;
}
$numberOfPosts = $currentNum + 10;
if (!($numberOfPosts >= 10)) {
    $numberOfPosts = 10;
}
require_once("../../view/Home/homeposts.php");
?>
