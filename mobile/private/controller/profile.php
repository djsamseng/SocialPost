<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/mobile/private/model/mobileFeeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/frienddb.php');
$_SESSION["lastPage"] = "profile";
if (isset($_POST["action"])) {
    $action = htmlspecialchars($_POST["action"]);
    $profileId = $_SESSION["id"];
    if (isset($_POST["profileId"])) {
        $profileId = htmlspecialchars($_POST["profileId"]);
        if ($profileId == null) {
            $profileId = $_SESSION["id"];
        }
    }
    if ($action == "getFeed") {
        if (isset($_POST["lastPostDate"]) && isset($_POST["loadBottom"])) {
            $lastPostDate = htmlspecialchars($_POST["lastPostDate"]);
            $loadBottom = htmlspecialchars($_POST["loadBottom"]);
            $feedData = getProfilePosts($_SESSION["id"],$profileId,null,$lastPostDate,$loadBottom);
        } else if (isset($_POST["firstPostDate"])) {
            $firstPostDate = htmlspecialchars($_POST["firstPostDate"]);
            $feedData = getProfilePosts($_SESSION["id"],$profileId,$firstPostDate,null,false);
        } else {
            $feedData = getProfilePosts($_SESSION["id"],$profileId,null,null,false);
        }
        $profileInfo = getProfileInfo($_SESSION["id"],$profileId);
        render("Profile/profilePosts",array("feedData"=>$feedData,"id"=>$_SESSION["id"]));
    } else if ($action == "getInfo") {
        $profInfo = getProfileInfo($_SESSION["id"],$profileId);
        render("Profile/profileInfo",array("profileInfo"=>$profInfo));
    } else if ($action == "getPhotos") {
        $profInfo = getProfileInfo($_SESSION["id"],$profileId);
        render("Profile/profilePhotos",array("profileInfo"=>$profInfo));
    } else if ($action == "getPlaces") {
        $profInfo = getProfileInfo($_SESSION["id"],$profileId);
        render("Profile/profilePlaces",array("profileInfo"=>$profInfo));
    } else if ($action == "getFriends") {
        $profInfo = getProfileInfo($_SESSION["id"],$profileId);
        render("Profile/profileFriends",array("profileInfo"=>$profInfo));
    } else if ($action == "getProfileById" && isset($_POST["profileId"])) {
        $profPic = getProfilePictures($_SESSION["id"],$profileId);
        $profPicUrl = '../../../private/model/pictures/'.$profileId.'/profilepictures/'.$profPic;
        $profInfo = getProfileInfo($_SESSION["id"],$profileId);
        if (isFriend($_SESSION["id"],$profileId)) {
            $friendStatus = "friends";
        } else if (isFriendPending($_SESSION["id"],$profileId)) {
            $friendStatus = "pending";
        } else if (isFriendPending($profileId,$_SESSION["id"])) {
            $friendStatus = "accept";
        } else {
            $friendStatus = "add";
        }
        render("profile",array("profileId"=>$profileId,"profPicUrl"=>$profPicUrl,"profileInfo"=>$profInfo,"friendStatus"=>$friendStatus));
    } else if ($action == "addFriend" && isset($_POST["profileId"])) {
        $profileId = htmlspecialchars($_POST["profileId"]);
        if ($profileId == $_SESSION["id"]) {
            exit;
        }
        $result = friendRequest($_SESSION["id"],$profileId);
        if ($result) {
            ?><form onsubmit="removeFriendRequest(this); return false;" method="post" action="">
                <input readonly="readonly" name="profileId" value="<?php echo $profileId;?>" style="display:none;">
                <input type="submit" value="Friends Pending">
            </form><?php
        }
    } else if ($action == "acceptFriend" && isset($_POST["profileId"])) {
        $profileId = htmlspecialchars($_POST["profileId"]);
        if ($profileId == $_SESSION["id"]) {
            exit;
        }
        $result = acceptFriend($_SESSION["id"],$profileId);
        if ($result) {
            echo "Friends";
        }
    } else if ($action == "removeFriendRequest" && isset($_POST["profileId"])) {
        $profileId = htmlspecialchars($_POST["profileId"]);
    }
    exit;
} else {
    $profPic = getProfilePictures($_SESSION["id"],$_SESSION["id"]);
    $profPicUrl = '../../../private/model/pictures/'.$_SESSION["id"].'/profilepictures/'.$profPic;
    $profileInfo = getProfileInfo($_SESSION["id"],$_SESSION["id"]);
    render("Profile/profile",array("profileId"=>$_SESSION["id"],"profPicUrl"=>$profPicUrl,"profileInfo"=>$profileInfo,"friendStatus"=>"none"));
    exit;
}


?>
