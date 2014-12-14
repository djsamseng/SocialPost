<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/mobile/private/model/mobileFeeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/postdb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/homefunctions.php');
$_SESSION["lastPage"] = "home";
if (isset($_POST["action"]) && isset($_POST["pass"]) && htmlspecialchars($_POST["pass"])) {
    $action = htmlspecialchars($_POST["action"]);
    if ($action == "logout") {
        $_SESSION["auth"] = false;
        unset($_SESSION["id"]);
        session_destroy();
        echo "logout";
        exit;
    } else if ($action == "getFeed") {
        if (isset($_POST["feedType"])) {
            $feedType = htmlspecialchars($_POST["feedType"]);
            if (isset($_POST["lastPostDate"]) && isset($_POST["loadBottom"])) {
                $lastPostDate = htmlspecialchars($_POST["lastPostDate"]);
                $loadBottom = htmlspecialchars($_POST["lastPostDate"]);
                $feedData = mobileGetFeed($_SESSION["id"],$feedType,null,$lastPostDate,$loadBottom);
            } else if (isset($_POST["firstPostDate"])) {
                $firstPostDate = htmlspecialchars($_POST["firstPostDate"]);
                $feedData = mobileGetFeed($_SESSION["id"],$feedType,$firstPostDate,null,null);
            } else {
                $feedData = mobileGetFeed($_SESSION["id"],$feedType);
            }
            render("Home/homePosts",array("id"=>$_SESSION["id"],"feedData"=>$feedData,"profPicUrl"=>getProfilePictures($_SESSION["id"],$_SESSION["id"])));
        }
        exit;
    } else if ($action == "likePost") {
        if (isset($_POST["postId"]) && isset($_POST["postersId"]) && isset($_POST["collection"])) {
            $postId = htmlspecialchars($_POST["postId"]);
            $postersId = htmlspecialchars($_POST["postersId"]);
            $collection = htmlspecialchars($_POST["collection"]);
            echo addLike($postersId, $collection, $postId, $_SESSION["id"]);
        }
        exit;
    } else if ($action == "dislikePost") {
        if (isset($_POST["postId"]) && isset($_POST["postersId"]) && isset($_POST["collection"])) {
            $postId = htmlspecialchars($_POST["postId"]);
            $postersId = htmlspecialchars($_POST["postersId"]);
            $collection = htmlspecialchars($_POST["collection"]);
            echo addDislike($postersId, $collection, $postId, $_SESSION["id"]);
        }
        exit;
    } else if ($action == "unlikePost") {
        if (isset($_POST["postId"]) && isset($_POST["collection"])) {
            $postId = htmlspecialchars($_POST["postId"]);
            $collection = htmlspecialchars($_POST["collection"]);
            echo unlikePost($collection, $postId, $_SESSION["id"], $_SESSION["id"]);
        }
        exit;
    } else if ($action == "undislikePost") {
        if (isset($_POST["postId"]) && isset($_POST["collection"])) {
            $postId = htmlspecialchars($_POST["postId"]);
            $collection = htmlspecialchars($_POST["collection"]);
            echo undislikePost($collection, $postId, $_SESSION["id"], $_SESSION["id"]);
        }
        exit;
    } else if ($action == "getUpdatedPost") {
        if (isset($_POST["postId"]) && isset($_POST["collection"])) {
            $postId = htmlspecialchars($_POST["postId"]);
            $collection = htmlspecialchars($_POST["collection"]);
            $feedData = getUpdatedPost($collection,$postId,$_SESSION["id"]);
            render("Home/homePosts",array("feedData"=>$feedData,"id"=>$_SESSION["id"],"profPicUrl"=>$feedData[0]['profPicUrl']));
        }
        exit;
    } else if ($action == "newPost") {
        if (isset($_POST["text"]) && isset($_POST["postTo"]) && isset($_POST["expireTime"]) && isset($_POST["near"]) && isset($_POST["lat"]) && isset($_POST["lng"]) && isset($_POST["radius"])) {
            $text = htmlspecialchars($_POST["text"]);
            $expireTime = htmlspecialchars($_POST["expireTime"]);
            $postTo = htmlspecialchars($_POST["postTo"]);
            $lat = htmlspecialchars($_POST["lat"]);
            $lng = htmlspecialchars($_POST["lng"]);
            $radius = htmlspecialchars($_POST["radius"]);
            $near = htmlspecialchars($_POST["near"]);
            if ($lat == "" || $lng == "" || $radius == "") {
                $lat = null;
                $lng = null;
                $radius = null;
            } else {
                try {
                    $lat = (int)$lat;
                    $lng = (int)$lng;
                    $radius = (int)$radius;
                } catch (Exception $e) {
                    $lat = null;
                    $lng = null;
                    $radius = null;
                }
            }
            controllerAddNewPost($_SESSION["id"],$text,$postTo,null,$lat,$lng,$radius,$near,$expireTime);
        }
        exit;
    } else if ($action == "newPhoto") {
        if (isset($_POST["text"]) && isset($_POST["postTo"]) && isset($_POST["expireTime"]) && isset($_FILES["file"])) {
            if (uploadMobilePhoto($_SESSION["id"], $_FILES["file"])) {
                echo "uploaded";
            }
        }
    } else if ($action == "getOnePost" && isset($_POST["postId"]) && isset($_POST["collection"])) {
        $postId = htmlspecialchars($_POST["postId"]);
        $collection = htmlspecialchars($_POST["collection"]);
        $post = getUpdatedPost($collection, $postId, $_SESSION["id"]);
        $profPic = getProfilePictures($_SESSION["id"], $_SESSION["id"]);
        $profPicUrl = $_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/pictures/'.$_SESSION["id"].'/profilepictures/'.$profPic;
        render("Home/onePost",array("post"=>$post,"id"=>$_SESSION["id"],"profPicUrl"=>$profPicUrl));
    } else if ($action == "removePost" && isset($_POST["postId"]) && isset($_POST["collection"])) {
        $postId = htmlspecialchars($_POST["postId"]);
        $collection = htmlspecialchars($_POST["collection"]);
        controllerDeletePost($_SESSION["id"],$collection,$postId,$_SESSION["id"]);
    }
    exit;
} else if (isset($_GET["action"])) {
    echo "here";
    $action = htmlspecialchars($_GET["action"]);
    if ($action == "getOnePost" && isset($_GET["postId"]) && isset($_GET["collection"])) {
        $postId = htmlspecialchars($_GET["postId"]);
        $collection = htmlspecialchars($_GET["collection"]);
        $post = getUpdatedPost($collection, $postId, $_SESSION["id"]);
        $profPic = getProfilePictures($_SESSION["id"], $_SESSION["id"]);
        $profPicUrl = $_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/pictures/'.$_SESSION["id"].'/profilepictures/'.$profPic;
        render("Home/onePost",array("post"=>$post,"id"=>$_SESSION["id"],"profPicUrl"=>$profPicUrl));
    }
} else if (isset($_GET["input"])) {
    $type = htmlspecialchars($_GET["input"]);
    if ($type == "text") {
        render("inputText",array("from"=>"home"));
    } else if ($type == "photo") {
        render("inputPhoto", array("from"=>"home"));
    } else {
        render("Home/home", array());
    }
    exit;
} else if (isset($_POST["page"])) {
    $page = htmlspecialchars($_POST["page"]);
    if ($page == "friendsFeed") {
        render("Home/home", array());
    } else if ($page == "home") {
        render("Home/home");
    }
    exit;
} else {
    render("Home/home");
    exit;
}
?>
