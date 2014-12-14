<?php

if (isset($_POST["job"])) {
    $job = htmlspecialchars($_POST["job"]);
    if ($job == "deletepost") {
        if (isset($_POST["postid"]) && isset($_POST["postersid"]) && isset($_POST["collection"]) && isset($_POST["id"])) {
            $postId = htmlspecialchars($_POST["postid"]);
            $postersId = htmlspecialchars($_POST["postersid"]);
            $collection = htmlspecialchars($_POST["collection"]);
            $id = htmlspecialchars($_POST["id"]);
            require_once("../../controller/homefunctions.php");
            controllerDeletePost($postersId,$collection,$postId,$id);
        }
    } else if ($job == "newpost") {
        if (isset($_POST["text"]) && isset($_POST["expiretime"]) && isset($_POST["postto"]) && isset($_POST["id"])) {
            if (isset($_POST["lat"]) && isset($_POST["lng"]) && isset($_POST["radius"])) {
                $lat = htmlspecialchars($_POST["lat"]);
                $lng = htmlspecialchars($_POST["lng"]);
                $radiusInM = htmlspecialchars($_POST["radius"]);
                $radius = ((float)$radiusInM) / (111120.0);//111.12km ~= 1 degree
            } else {
                $lat = null;
                $lng = null;
                $radius = null;
            }
            $text = htmlspecialchars($_POST["text"]);
            $expireTime = htmlspecialchars($_POST["expiretime"]);
            $postTo = htmlspecialchars($_POST["postto"]);
            $id = htmlspecialchars($_POST["id"]);
            require_once("../../controller/homefunctions.php");
            controllerAddNewPost($id,$text,$postTo,null,$lat,$lng,$radius,"",$expireTime);
        }
    }
}
exit;


?>
