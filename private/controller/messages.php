<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/searchdb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/messagedb.php');

if (isset($_SESSION["id"]) && $_SESSION["id"] > 0 && isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    getMessages($_SESSION["id"]);
} else {
    require_once('login');
    exit;
}

function checkAction() {
    if (isset($_GET["action"])) {
        $action = htmlspecialchars($_GET["action"]);  
        if ($action == "sitetoggle") {
            if (isset($_SESSION["sitetoggle"])) {
                if ($_SESSION["sitetoggle"]) {
                    $_SESSION["sitetoggle"]=false;
                } else {
                    $_SESSION["sitetoggle"]=true;
                }
            } else {
                $_SESSION["sitetoggle"] = false;
            }
            header("Location: index.php?page=messages");
            exit;
        } else if ($action == "searchfriends") {
            if (isset($_POST["messagefriendsearch"])) {
                $search = htmlspecialchars($_POST["messagefriendsearch"]);
                $limit = 10;
                if (isset($_POST["limit"])) {
                    $limit = htmlspecialchars($_POST["limit"]);
                }
                return messageSearchFriends($_SESSION["id"],$search,$limit);
            }
            return null;
        } else if ($action == "addtomessage") {
            if (isset($_POST["addtomessageid"]) && isset($_POST["messageid"])) {
                $addToMessageId = htmlspecialchars($_POST["addtomessageid"]);
                $messageId = htmlspecialchars($_POST["messageid"]);//needs to be encoded/decoded
                $messageId = addIdToMessageAction($_SESSION["id"],$messageId,$addToMessageId);
                if (isset($_POST["newinputtext"]) && isset($_POST["expireTime"])) {
                    $text = htmlspecialchars($_POST["newinputtext"]);
                    $expireTime = htmlspecialchars($_POST["expireTime"]);
                    addMessageToConvo($messageId,$_SESSION["id"],$text,$expireTime);
                }
                header("Location: index.php?page=messages&type=message&messageid=".$messageId);
                exit;
            }
        } else if ($action == "addmessagetoconvo") {
            if (isset($_POST["messageid"]) && isset($_POST["addmessagetext"]) && isset($_POST["expireTime"])) {
                $messageId = htmlspecialchars($_POST["messageid"]);
                $text = htmlspecialchars($_POST["addmessagetext"]);
                $expireTime = htmlspecialchars($_POST["expireTime"]);
                addMessageToConvo($messageId,$_SESSION["id"],$text,$expireTime);
                header("Location: index.php?page=messages&type=message&messageid=".$messageId);
            }
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
            header("Location: index.php?page=messages");
            exit;
        }
    }
    return null;
}

function addMessageToConvo($messageId,$id,$text,$expireTime) {
    if ($expireTime=="Never") {
        $expire = "";
    } else if ($expireTime=="5 Minutes") {
        $expire=(new MongoDate(strtotime("+5 Minute")))->sec;
    } else if ($expireTime=="2 Hours") {
        $expire=(new MongoDate(strtotime("+2 Hour")))->sec;
    } else if ($expireTime=="1 Day") {
        $expire=(new MongoDate(strtotime("+1 Day")))->sec;
    } else if ($expireTime=="30 Days") {
        $expire=(new MongoDate(strtotime("+30 Day")))->sec;
    } else if ($expireTime=="1 Year") {
        $expire=(new MongoDate(strtotime("+1 Year")))->sec;
    } else {
        $expire = "";
    }
    if (strlen($messageId)>0 && strlen($text)>0) {
        addMessage($messageId,$id,$text,$expire);
    }
    return;
}


function addIdToMessageAction($id,$messageId,$addToMessageId) {
    if (!(strlen($addToMessageId) > 0)) {
        return;
    }
    if (strlen($messageId) > 0) {
        addIdToMessage($id,$messageId,$addToMessageId);
    } else if ($messageId == "") {
        $messageId = createNewMessage($id,$addToMessageId);
    }
    return $messageId;
}

    

function messageSearchFriends($id,$search,$limit) {
    if (!(strlen($search) > 0)) {
        return null;
    }
    if (!($limit > 0 && $limit < 100)) {
        $limit = 10;
    }
    $searchResults = searchAll($id,$search,$limit);
    for ($i=0;$i<count($searchResults);$i++) {
        $searchResults[$i]["profPicUrl"]="../private/model/pictures/".$searchResults[$i]['_id']->{'$id'}."/profilepictures/".getProfilePictures($id,$searchResults[$i]['_id']->{'$id'});
    }
    return $searchResults;
}

function getPageType() {
    $type = "main";
    if (isset($_GET["type"])) {
        $type = htmlspecialchars($_GET["type"]);
        if ($type != "newmessage" && $type != "message") {
            $type = "main";
        }
    }
    return $type;
}

function getMessageId() {
    $messageId = "";
    if (isset($_GET["messageid"])) {
        $messageId = htmlspecialchars($_GET["messageid"]);
    }
    return $messageId;
}
function getMessageData($messageId,$id,$limit=20) {
    $messageData = null;
    if (strlen($messageId) > 0) {
        $messageData = getMessage($messageId,$id,$limit);
        $messageData = $messageData;
    }
    return $messageData;
}
    
function getMessages($id) {
    $messageId = getMessageId();
    $actionData = checkAction();
    $type = getPageType();
    $messageData = null;
    if ($type == "message") {
        $messageData = getMessageData($messageId,$id);
    }
    $profpic = getProfilePictures($id,$id);
    $allMessages = getUserMessageData($id);
    render("Conversations/conversations",array("id"=>$id,"type"=>$type,"actionData"=>$actionData,"messageId"=>$messageId,"allMessages"=>$allMessages,"messageData"=>$messageData,"profpicurl"=>"../private/model/pictures/".$id."/profilepictures/".$profpic));
}
?>
