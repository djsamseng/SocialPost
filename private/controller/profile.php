<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/frienddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/postdb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');
if (isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);
    if (strlen($id) < 1) {
        header("Location: index.php");
        exit;
    }
} else {
    $id = $_SESSION["id"];
}
if (isset($_GET["action"])) {
    $action = htmlspecialchars($_GET["action"]);
    if ($action == "uploadprofpic" && isset($_POST["profpicfilename"])&& $_SESSION["id"]==$id) {
        $profpicfilename = $_POST["profpicfilename"];
        if (file_exists("../private/model/pictures/".$_SESSION["id"]."/profilepictures/".$profpicfilename)) {
            $result = addProfilePicture($_SESSION["id"],$profpicfilename);
        }
    } else if ($action == "uploadprofpicfile" && isset($_FILES["file"]) && $_SESSION["id"]==$id) {
        $uploadresult = uploadProfilePicture($_SESSION["id"],$_FILES["file"]);
        if ($uploadresult) {
            header("Location: profile.php?subpage=photosSubpage");
            exit;
        }
    } else if ($action == "friendRequest" && isset($_SESSION["friendRequest"]) && $id != $_SESSION["id"] && $_SESSION["friendRequest"] == $id) {
        $result = friendRequest($_SESSION["id"],$_SESSION["friendRequest"]);
        $_SESSION["friendRequest"] = null;
        header("Location: profile.php?id=".$id);
    } else if ($action == "acceptFriend" && isset($_SESSION["acceptFriend"]) && $id != $_SESSION["id"] && $_SESSION["acceptFriend"] == $id) {
        $result = acceptFriend($_SESSION["id"],$_SESSION["acceptFriend"]);
        $_SESSION["acceptFriend"] = null;
         header("Location: profile.php?id=".$id);
    } else if ($action == "newpost" && isset($_POST["newpost"]) && isset($_POST["postTo"])) {
        addProfilePost(htmlspecialchars($_POST["newpost"]),htmlspecialchars($_POST["postTo"]),$id,$_SESSION["id"]);
    }
}
if (isset($_GET["id"])) {
    getProfile($_SESSION["id"],$id,10);
} else {
    getProfile($_SESSION["id"],$_SESSION["id"],10);
}
function getProfile($userId,$profileId,$numOfPosts) {
    $posts = getProfilePosts($userId,$profileId);
    /*for ($i=0;$i<count($posts);$i++){
        $postByInfo = getProfileInfo($userId,$posts[$i]['posts']['userId']);
        $posts[$i]["posts"]["postByName"] = $postByInfo;
        $posts[$i]["posts"]["postByPicUrl"] = "../private/model/pictures/".$posts[$i]['posts']['userId']."/profilepictures/".getProfilePictures($userId,$posts[$i]['posts']['userId']);
    }*/
    $info = getProfileInfo($userId,$profileId);
    $profpic = getProfilePictures($userId,$profileId);
    render('profile',array("id"=>$userId,"info"=>$info,"profpicurl"=>"../private/model/pictures/".$profileId."/profilepictures/".$profpic,"profposts"=>$posts,"isOwn"=>($_SESSION["id"]==$profileId),"isFriend"=>isFriend($userId,$profileId),"isFriendPending"=>isFriendPending($userId,$profileId),"isFriendWaiting"=>isFriendPending($profileId,$userId)));
}
/*function getMyProfile($userId,$numOfPosts) {
    $posts = getProfilePosts($userId,$userId,$numOfPosts);
    $info = getProfileInfo($userId,$userId);
    $profpic = getProfilePictures($userId,$userId);
    render('profile',array("id"=>$userId,"info"=>$info,"profpicurl"=>"../private/model/pictures/".$userId."/profilepictures/".$profpic,"profposts"=>$posts));
}*/
function addProfilePost($newPost,$postTo,$idcheck,$userId) {
    if ($postTo != $idcheck) {
        return;
    }
    if (strlen($newPost)<1) {
        return;
    }
    addPost($postTo,$userId,$newPost);
    //header("Location: profile.php?id=".$postTo);
    // && htmlspecialchars($_POST["postTo"])==$id && strlen(htmlspecialchars($_POST["newpost"])) > 0
}
function getSubPage($info,$profposts,$profpicurl){
    if (isset($_GET["subpage"])) {
        $subpage = htmlspecialchars($_GET["subpage"]);
    } else {
        $subpage = "postsSubpage";
    }
    require_once("../private/controller/profileSubPages/".$subpage.".php");
    renderSubPage($info,$profposts,$profpicurl);
    //render("profileSubpages/".$subpage,array("info"=>$info,"profposts"=>$profposts,"profpicurl"=>$profpicurl));
}
function printHello() {
    echo "hello!";
}
