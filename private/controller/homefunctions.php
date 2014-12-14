<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/frienddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/postdb.php');


function checkAction($action,$feedtype,$inputstate) {
    $numberOfPosts = null;
    if (isset($_POST["newpost"]) && $action == "newpost" && isset($_POST["postTo"]) && isset($_POST["expireTime"])) {
            $newPost = htmlspecialchars($_POST["newpost"]);
            $postTo = htmlspecialchars($_POST["postTo"]);
            $expireTime = htmlspecialchars($_POST["expireTime"]);
            controllerAddNewPost($_SESSION["id"],$newPost,$postTo,null,null,null,null,"",$expireTime);
            header("Location: index.php?page=home&feedtype=".$feedtype);
    } else if ($action == "sitetoggle") {
        if (isset($_SESSION["sitetoggle"])) {
            if ($_SESSION["sitetoggle"]) {
                $_SESSION["sitetoggle"]=false;
            } else {
                $_SESSION["sitetoggle"]=true;
            }
        } else {
            $_SESSION["sitetoggle"] = false;
        }
        header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
    } else if ($action == "chattoggle") {
        if (isset($_SESSION["chattoggle"])) {
            if ($_SESSION["chattoggle"]) {
                $_SESSION["chattoggle"] = false;
            } else {
                $_SESSION["chattoggle"] = true;
            }
        } else {
            $_SESSION["chattoggle"] = false;
        }
        header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
    } else if ($action == "newcomment" && isset($_POST["newcomment"]) && isset($_POST["postid"])&& isset($_POST["postersid"]) && isset($_POST["collection"])) {
        $newcomment = htmlspecialchars($_POST["newcomment"]);
        $postid = htmlspecialchars($_POST["postid"]);
        $postersid = htmlspecialchars($_POST["postersid"]);
        $collection = htmlspecialchars($_POST["collection"]);
        if (strlen($newcomment)>0 && strlen($postid)>0 && strlen($postersid)>0) {
            addComment($postersid, $collection, $postid, $_SESSION["id"], $newcomment);
            header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
        }
    } else if ($action == "likeaction" && isset($_POST["postid"]) && isset($_POST["postersid"]) && isset($_POST["collection"])) {
        $postid = htmlspecialchars($_POST["postid"]);
        $postersid = htmlspecialchars($_POST["postersid"]);
        $collection = htmlspecialchars($_POST["collection"]);
        if (strlen($collection)>0 && strlen($postid)>0 && strlen($postersid)>0) {
            if (isset($_POST["like"]) && htmlspecialchars($_POST["like"])=="Like") {
                addLike($postersid, $collection, $postid, $_SESSION["id"]);
                header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
            } else if (isset($_POST["dislike"]) && htmlspecialchars($_POST["dislike"])=="Dislike") {
                addDislike($postersid, $collection, $postid, $_SESSION["id"]);
                header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
            }
        }
    } else if ($action == "commentlikeaction" && isset($_POST["postid"]) && isset($_POST["postersid"]) && isset($_POST["collection"]) && isset($_POST["commentid"])) {
        $postid = htmlspecialchars($_POST["postid"]);
        $postersid = htmlspecialchars($_POST["postersid"]);
        $collection = htmlspecialchars($_POST["collection"]);
        $commentid = htmlspecialchars($_POST["commentid"]);
        if (strlen($postid)>0 && strlen($postersid)>0 && strlen($collection)>0 && strlen($commentid)>0) {
            if (isset($_POST["like"]) && htmlspecialchars($_POST["like"]) == "Like") {
                addCommentLike($postersid, $collection, $postid, $commentid, $_SESSION["id"]);
                header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
            } else if (isset($_POST["dislike"]) && htmlspecialchars($_POST["dislike"]) == "Dislike") {
                addCommentDislike($postersid, $collection, $postid, $commentid, $_SESSION["id"]);
                header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
            }
        }
    } else if ($action == "deletepost" && isset($_POST["postid"]) && isset($_POST["postersid"]) && isset($_POST["collection"])) {
        $postId = htmlspecialchars($_POST["postid"]);
        $postersId = htmlspecialchars($_POST["postersid"]);
        $collection = htmlspecialchars($_POST["collection"]);
        controllerDeletePost($postersId,$collection,$postId,$_SESSION["id"]);
        header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
    } else if ($action == "deletecomment" && isset($_POST["postid"]) && isset($_POST["usercommentid"]) && isset($_POST["collection"]) && isset($_POST["commentid"])) {
        $postId = htmlspecialchars($_POST["postid"]);
        $userCommentId = htmlspecialchars($_POST["usercommentid"]);
        $collection = htmlspecialchars($_POST["collection"]);
        $commentId = htmlspecialchars($_POST["commentid"]);
        if (strlen($postId)>0 && strlen($userCommentId)>0 && strlen($collection)>0 && strlen($commentId)>0) {
            removeComment($collection, $postId, $commentId, $userCommentId, $_SESSION["id"]);
            header("Location: index.php?page=home&feedtype=".$feedtype."&inputstate=".$inputstate);
        }
    } 
}

function controllerDeletePost($postersId,$collection,$postId,$id) {
    if (strlen($postId)>0 && strlen($postersId)>0 && strlen($collection)>0) {
        $result = removePost($postersId, $collection, $postId, $id);
    }
}

function getInputState() {
    $inputtype = "";
    $inputstate = "";
    if (isset($_GET["inputstate"])) {
        $inputstate = htmlspecialchars($_GET["inputstate"]);
        if (isset($_GET["input"])) {
            $input = htmlspecialchars($_GET["input"]);
            if ($inputstate != "text" && $input == "text") {
                $inputstate = "text";
            } else if ($inputstate != "photo" && $input == "photo") {
                $inputstate = "photo";
            } else if ($inputstate != "video" && $input == "video") {
                $inputstate = "video";
            } else if ($inputstate != "location" && $input == "location") {
                $inputstate = "location";
            } else if ($inputstate != "link" && $input == "link") {
                $inputstate = "link";
            } else {
                $inputstate = "";
            }
        }
    }
    if ($inputstate != "text" && $inputstate != "photo" && $inputstate != "video" && $inputstate != "location" && $inputstate != "link") {
        $inputstate = "";
    }
    return $inputstate;
}

function getFeedType($feedtype="friends") {
    if (isset($_GET["feedtype"])) {
        $feedtype = htmlspecialchars($_GET["feedtype"]);
    }
    if ($feedtype == "friends"){
        $printfeed = "Friends";
    } else if ($feedtype == "world") {
        $printfeed = "World";
    } else if ($feedtype == "nearme") {
        $printfeed = "Near Me";
    } else {
        $printfeed = "Friends";
        $feedtype = "friends";
    }
    return array("feedtype"=>$feedtype,"printfeed"=>$printfeed);
}

function getNumberOfPosts() {
    $numberOfPosts = null;
    if (isset($_GET["action"])) {
        $action = htmlspecialchars($_GET["action"]);
        if ($action == "getmoreposts" && isset($_POST["currentnumberofposts"])) {
            $numberOfPosts = (int)(htmlspecialchars($_POST["currentnumberofposts"])) + 10;
        }
    }
    if (!($numberOfPosts >= 10)) {
        $numberOfPosts = 10;
    }
    return $numberOfPosts;
}
function convertExpireTime($expireTime) {
    if ($expireTime=="Never") {
        $expire = "";
    } else if ($expireTime=="5 Minutes") {
        $expire=strtotime("+5 Minute");
    } else if ($expireTime=="2 Hours") {
        $expire=strtotime("+2 Hour");
    } else if ($expireTime=="1 Day") {
        $expire=strtotime("+1 Day");
    } else if ($expireTime=="30 Days") {
        $expire=strtotime("+30 Day");
    } else if ($expireTime=="1 Year") {
        $expire=strtotime("+1 Year");
    } else {
        $expire = "";
    }
    return $expire;
}
    
function controllerAddNewPost($id,$text,$postTo,$privacy,$lat,$lng,$radius,$near,$expireTime,$picUrl="") {
        $expire = convertExpireTime($expireTime);
        if (strlen($text)>0) {
        if ($postTo == "World") {
            addPost($id,$id,$text,"world",array("type"=>"all","blocked"=>array()),$lat,$lng,$radius,$near,$expire,$picUrl);
            return;
        } else if ($postTo == "Friends") {
            addPost($id,$id,$text,"friendsworld",array("type"=>"friends","blocked"=>array()),$lat,$lng,$radius,$near,$expire,$picUrl);
            return;
        }
    }
}
    
    
function getHome($id,$firstpostdate=null,$lastpostdate=null,$feedtype="friends",$loadBottom=false,$newLoad=true,$numberOfPosts=10,$lat=null,$lng=null) {
    if ($newLoad) {
        $firstpostdate = null;
        $lastpostdate = null; 
    }
    if ($loadBottom) {
        $firstpostdate = null;
    } else {
        $lastpostdate = null; //either load posts after and append or load posts before and prepend
    }
    $inputstate = getInputState();
    $feedinfo = getFeedType($feedtype);
    $feedtype = $feedinfo["feedtype"];
    $printfeed = $feedinfo["printfeed"];
    $profpic = getProfilePictures($id,$id);
    $requests = getRequests($id);
    for ($i=0;$i<count($requests["friendRequests"]);$i++) {
        $info = getProfileInfo($id,$requests["friendRequests"][$i]["userId"]);
        $requests["friendRequests"][$i]["firstname"] = $info["firstname"];
        $requests["friendRequests"][$i]["lastname"] = $info["lastname"];
    }
    if ($feedtype == "friends") {
        $feeddata = getFriendsFeed($id,$firstpostdate,$lastpostdate,$loadBottom,$lat,$lng,$numberOfPosts);
        $printfeed = "Friends";
    } else if ($feedtype == "world") {  
        $printfeed = "World";
        $feeddata = getWorldFeed($numberOfPosts,$firstpostdate,$lastpostdate,$loadbottom);
    } else if ($feedtype == "nearme") {
        $printfeed = "Near Me";
    }
        $feeddata = getCommentInfo($id,$feeddata);
    return array("profpicurl"=>"../private/model/pictures/".$id."/profilepictures/".$profpic,"feeddata"=>$feeddata,"input"=>$inputstate,"printfeed"=>$printfeed,"feedtype"=>$feedtype,"requests"=>$requests,"numberOfPosts"=>$numberOfPosts);
}

function getCommentInfo($id,$feeddata, $num=10) {
    date_default_timezone_set('EST');
    //print_r($feeddata[0]);
    for ($i=0; $i<count($feeddata); $i++) {
        if (count($feeddata[$i]["comments"]) < $num) {
            $limit = count($feeddata[$i]["comments"]);
        } else {
            $limit = $num;
        }
        for ($j=0;$j<$limit;$j++) {
            $info = getProfileInfo($id, $feeddata[$i]["comments"][$j]["userId"]);
            $feeddata[$i]["comments"][$j]["firstname"] = $info["firstname"];
            $feeddata[$i]["comments"][$j]["lastname"] = $info["lastname"];
            $feeddata[$i]["comments"][$j]["date"] = date("M d h:i a",$feeddata[$i]["comments"][$j]["date"]->sec);
            $feeddata[$i]["comments"][$j]["profPicUrl"] = "../private/model/pictures/".$feeddata[$i]["comments"][$j]["userId"]."/profilepictures/".getProfilePictures($id,$feeddata[$i]["comments"][$j]["userId"]);
        }
    }
    return $feeddata;
}

?>
