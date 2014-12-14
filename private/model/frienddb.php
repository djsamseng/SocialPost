<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
function friendRequest($userId,$profileId) {
    //$userId is the current user, $profileId is whom the current user is requesting
    //arguemnts are type string
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $cursor = $db->users->update(array('_id'=>new MongoId($profileId)),array('$push'=>array("requests.friendRequests"=>array("userId"=>new MongoId($userId),"date"=>new MongoDate()))));
        $cursor = $db->users->update(array('_id'=>new MongoId($userId)),array('$push'=>array("requestsMade.friendRequestsMade"=>array("profileId"=>new MongoId($profileId),"date"=>new MongoDate()))));
    } catch (Exception $e) {
        print_r("Failed to update");
        print_r($e);
    }
    return true;
}
function getRequests($userId) {
    //argument is type string
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $cursor = $db->users->find(array('_id'=>new MongoId($userId)),array("requests.friendRequests"=>1,"_id"=>0));
        $results = null;
        if ($cursor->hasNext()) {
            $results = $cursor->getNext();
        }
    } catch (Exception $e) {
        echo "error getting friend requests";
        return null;
    }
    return $results["requests"];
}
function isFriend($userId,$profileId) {
    //arguments are type MongoId
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $cursor = $db->users->find(array('$and'=>array(array('_id'=>new MongoId($profileId)),array("friends._id"=>new MongoId($userId)))));
        $result = $cursor->getNext();
    } catch (Exception $e) {
        echo "error in isFriend";
        print_r($e);
        return false;
    }
    return count($result)>0;
}
function isFriendPending($userId,$profileId) {
    //arguments are type MongoId
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $cursor = $db->users->find(array('$and'=>array(array('_id'=>new MongoId($userId)),array('requestsMade.friendRequestsMade.profileId'=>new MongoId($profileId)))));
        $result = $cursor->getNext();
    } catch (Exception $e) {
        echo "error in isFriend";
        print_r($e);
        return false;
    }
    return count($result)>0;
}
    
function addFriend($userId,$profileId) {
    //This makes two people friends
    //arguements are type MongoId
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $results = $db->users->update(array('_id'=>new MongoId($profileId)),array('$push'=>array('friends'=>array("_id"=>new MongoId($userId),"date"=>new MongoDate()))));
        $results = $db->users->update(array('_id'=>new MongoId($userId)),array('$push'=>array('friends'=>array("_id"=>new MongoId($profileId),"date"=>new MongoDate()))));
    } catch (Exception $e) {
        echo "error in addFriend";
        print_r($e);
        return false;
    }
    return true;
}
function acceptFriend($userId,$profileId) {
    //arguements are type MongoId
    $db = connect();
    if ($db == null) {
        return false;
    }
    if (isFriendPending($profileId,$userId) && !isFriend($userId,$profileId)) {
        $result = addFriend($userId,$profileId);
        if ($result) {
            try {
                $db->users->update(array('_id'=>new MongoId($userId)),array('$pull'=>array('requests.friendRequests'=>array('userId'=>new MongoId($profileId)))));
                $db->users->update(array('_id'=>new MongoId($profileId)),array('$pull'=>array('requestsMade.friendRequestsMade'=>array('profileId'=>new MongoId($userId)))));
            } catch (Exception $e) {
                echo "error in acceptFriend";
                print_r($e);
            }
            $result = true;
        }
    }
    return false;
}
function getFriends($userId,$profileId,$numberOfFriends=9) {
    //arguemnts are type MongoId, numberOfFriends type int
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $results = $db->users->aggregate(array(array('$match'=>array('_id'=>new MongoId($profileId))),array('$project'=>array('friends'=>1)),array('$unwind'=>'$friends'),array('$sort'=>array("friends.date"=>-1))));//,array('$limit'=>$numberOfFriends)
    } catch (Exception $e) {
        echo "error in getFriends";
        print_r($e);
        return null;
    }
    //print_r($results);
    return $results["result"];
}

?>


