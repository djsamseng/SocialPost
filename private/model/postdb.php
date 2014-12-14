<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');

function addPost($postToId,$byId,$post,$collection="world",$privacy=array("type"=>"all","blocked"=>array()),$long=0,$lat=0,$r=90,$near="",$expiration="",$picUrl="") {
    $db = connect();
    if ($db == null) {
        return false;
    }
    if (!($lat > -180 && $lat < 180 && $long > -180 && $long < 180)) {
        $lat = 0;
        $long = 0;
        $r = 90;
    }
    date_default_timezone_set('EST');
    if ($expiration == "") {    
        $expiration = new MongoDate(strtotime("2114-01-01 00:00:00"));
    } else {
        $expiration = new MongoDate($expiration);
    }
    $info = array("_id"=>new MongoId($postToId));
    $postId = new MongoId();
    $date = new MongoDate();
    if (!(array_key_exists("type",$privacy))) {
        echo "privacy[type] DNE";
        return false;
    }
    if ($privacy["type"] == "all") {
        if (!(array_key_exists("blocked",$privacy)) || count($privacy) > 2) {
            echo "invalid privacy for type all";
            return false;
        }
    } else if ($privacy["type"] == "friends") {
        if (!(array_key_exists("blocked",$privacy)) || count($privacy) > 2) {
            echo "invalid privacy for type friends";
            return false;
        }
        if ($collection == "world") { //world is public and can be seen by anyone except those on the blocked list
            $collection = "friendsworld";//friendsworld should only be accessed through finding postIds from going through friends posts through friends list
        }
    } else if ($privacy["type"] == "allowed") {
        if (!(array_key_exists("allowed",$privacy)) || count($privacy) > 2) {
            echo "invalid privacy for type allowed";
            return false;
        }
    } else {
        return false;
    }

    $loc = array('type'=>'Polygon','coordinates'=>array(array(array($long-$r,$lat-$r),array($long+$r,$lat-$r),array($long+$r,$lat+$r),array($long-$r,$lat+$r),array($long-$r,$lat-$r))));
        try {
            $cursor = $db->users->update($info,array(
                '$push'=>array(
                "posts"=>array(
                    "_id"=>new MongoId($postId),
                    "userId"=>new MongoId($byId),
                    "collection"=>$collection,
                    "date"=>$date,
                    "dateEdited"=>$date,
                    "expiration"=>$expiration,
                    "loc"=>$loc,
                    "privacy"=>$privacy
                )
            )
        ));
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
        try {
            $cursor = $db->$collection->insert(array(
                "_id"=>new MongoId($postId),
                "userId"=>new MongoId($byId),
                "text"=>$post,
                "date"=>$date,
                "dateEdited"=>$date,
                "expiration"=>$expiration,
                "collection"=>$collection,
                "loc"=>$loc,
                "near"=>$near,
                "comments"=>array(),
                "commentCount"=>0,
                "likes"=>array(),
                "likeCount"=>0,
                "dislikes"=>array(),
                "dislikeCount"=>0,
                "lastAction"=>array("action"=>"posted","userId"=>new MongoId($byId)),
                "privacy"=>$privacy,
                "picUrl"=>$picUrl
            ));
        } catch (Exception $e) {
            return false;
        }
        return true;
}

function addComment($postersId, $collection, $postId, $userId, $comment, $lat=0,$long=0) {
    //need to verify that commenter is valid to comment both by loc and by permissions
    $db = connect();
    if ($db == null) {
        return false;
    }
    if ($lat < -180 || $lat > 180 || $long < -180 || $long > 180) {
        return false;
    }
    $date = new MongoDate();
    date_default_timezone_set('EST');
    $postersInfo = array("_id"=>new MongoId($postersId));
    $postInfo = array("_id"=>new MongoId($postId));
    try {
        $cursor = $db->users->update(
            array(//query criteria
                "_id"=>new MongoId($postersId),
                'posts._id'=>new MongoId($postId),
                '$or'=>array(
                    array(
                        'posts.privacy.type'=>'all',
                        '$not'=>array('posts.privacy.blocked'=>new MongoId($userId))
                    ),
                    array(
                        'posts.privacy.type'=>'friends',
                        'friends._id'=> new MongoId($userId),
                        '$not'=>array('posts.privacy.blocked'=>new MongoId($userId))
                    ),
                    array(
                        'posts.privacy.type'=>'allowed',
                        'posts.privacy.allowed'=>new MongoId($userId)
                    )
                )
            ),
            array(//the update
                '$set'=>array(
                    'posts.$.dateEdited'=>$date
                )
            )
        );
        print_r($cursor);
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$push'=>array(
                "comments"=>array(
                    "_id"=> new MongoId(),
                    "userId"=>new MongoId($userId),
                    "date"=> $date,
                    "likes" => array(),
                    "dislikes" => array(),
                    "text"=>$comment
                )
            )
        ));
        print_r($cursor);
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$set'=>array(
                "dateEdited"=>$date,
                "lastAction"=>array("action"=>"comment","userId"=>new MongoId($postersId))
            )
        ));
        print_r($cursor);
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$inc'=>array(
                "commentCount"=>1,
            )
        ));
        print_r($cursor);
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    return true;
}
function addLike($postersId, $collection, $postId, $userId, $lat=0,$long=0) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    if ($lat < -180 || $lat > 180 || $long < -180 || $long > 180) {
        return false;
    }
    $date = new MongoDate();
    date_default_timezone_set('EST');
    $postersInfo = array("_id"=>new MongoId($postersId));
    $postInfo = array("_id"=>new MongoId($postId));
    try {
        $result = $db->$collection->findOne(array("_id"=>new MongoId($postId),'likes._id'=>new MongoId($userId)),array('likes._id'=>1));
        if (count($result) > 0) {
            return false;
        }
    } catch (Exception $e) {
        echo 'Error checking previous like';
        return false;
    }   
    try {
        $cursor = $db->users->update(array("_id"=>new MongoId($postersId),'posts._id'=>new MongoId($postId)),array(
            '$set'=>array(
                'posts.$.dateEdited'=>$date
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$push'=>array(
                "likes"=>array(
                    "_id"=> new MongoId($userId),
                    "date"=> $date,
                )
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$set'=>array(
                "dateEdited"=>$date,
                "lastAction"=>array("action"=>"like","userId"=>new MongoId($postersId))
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$inc'=>array(
                "likeCount"=>1,
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    return true;
}

function addDislike($postersId, $collection, $postId, $userId, $lat=0,$long=0) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    if ($lat < -180 || $lat > 180 || $long < -180 || $long > 180) {
        return false;
    }
    $date = new MongoDate();
    date_default_timezone_set('EST');
    $postersInfo = array("_id"=>new MongoId($postersId));
    $postInfo = array("_id"=>new MongoId($postId));
    try {
        $result = $db->$collection->findOne(array("_id"=>new MongoId($postId),'dislikes._id'=>new MongoId($userId)),array('dislikes._id'=>1));
        if (count($result) > 0) {
            return false;
        }
    } catch (Exception $e) {
        echo 'Error checking previous like';
        return false;
    }   
    try {
        $cursor = $db->users->update(array("_id"=>new MongoId($postersId),'posts._id'=>new MongoId($postId)),array(
            '$set'=>array(
                'posts.$.dateEdited'=>$date
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$push'=>array(
                "dislikes"=>array(
                    "_id"=> new MongoId($userId),
                    "date"=> $date,
                )
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$set'=>array(
                "dateEdited"=>$date,
                "lastAction"=>array("action"=>"dislike","userId"=>new MongoId($postersId))
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    try {
        $cursor = $db->$collection->update($postInfo,array(
            '$inc'=>array(
                "dislikeCount"=>1,
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    return true;
}

function addCommentLike($postersId, $collection, $postId, $commentId, $userId, $lat=0,$long=0) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    if ($lat < -180 || $lat > 180 || $long < -180 || $long > 180) {
        return false;
    }
    $date = new MongoDate();
    date_default_timezone_set('EST');
    $postersInfo = array("_id"=>new MongoId($postersId));
    $postInfo = array("_id"=>new MongoId($postId));
    try {
        $result = $db->$collection->findOne(array("_id"=>new MongoId($postId),'comments'=>array('$elemMatch'=>array('_id'=>new MongoId($commentId),'likes._id'=>new MongoId($userId)))));
        if (count($result)>0) {
            return false;
        }
    } catch (Exception $e) {
        echo 'Error checking previous like';
        return false;
    }   
    try {
        $cursor = $db->$collection->update(array('_id'=>new MongoId($postId),'comments._id'=>new MongoId($commentId)),array(
            '$push'=>array(
                "comments.$.likes"=>array(
                    "_id"=> new MongoId($userId),
                    "date"=> $date,
                )
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    return true;
}

function addCommentDislike($postersId, $collection, $postId, $commentId, $userId, $lat=0,$long=0) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    if ($lat < -180 || $lat > 180 || $long < -180 || $long > 180) {
        return false;
    }
    $date = new MongoDate();
    date_default_timezone_set('EST');
    $postersInfo = array("_id"=>new MongoId($postersId));
    $postInfo = array("_id"=>new MongoId($postId));
    try {
        $result = $db->$collection->findOne(array("_id"=>new MongoId($postId),'comments'=>array('$elemMatch'=>array('_id'=>new MongoId($commentId),'dislikes._id'=>new MongoId($userId)))));
        if (count($result)>0) {
            return false;
        }
    } catch (Exception $e) {
        echo 'Error checking previous like';
        return false;
    }   
    try {
        $cursor = $db->$collection->update(array('_id'=>new MongoId($postId),'comments._id'=>new MongoId($commentId)),array(
            '$push'=>array(
                "comments.$.dislikes"=>array(
                    "_id"=> new MongoId($userId),
                    "date"=> $date,
                )
            )
        ));
    } catch (Exception $e) {
        print_r($e);
        return false;
    }
    return true;
}

function removePost($postersId, $collection, $postId, $userId) {
    if ($postersId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->users->update(array('_id'=>new MongoId($postersId)),array('$pull'=>array('posts'=>array('_id'=>new MongoId($postId)))));
    } catch (Exception $e) {
        echo "error removing post from users";
        return false;
    }
    try {
        $result = $db->$collection->remove(array('_id'=> new MongoId($postId)));
    } catch (Exception $e) {
        echo "error removing post from collection";
        return false;
    }
    return true;
}

function removeComment($collection, $postId, $commentId, $userCommentId, $userId) {
    if ($userCommentId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->$collection->findOne(array('_id'=>new MongoId($postId),'comments._id'=>new MongoId($commentId)));
        if (count($result) < 1) {
            return false;
        }
    } catch (Exception $e) {
        echo "error checking if user has commented on the post before removing";
        return false;
    }
    try {
        $result = $db->$collection->update(array('_id'=>new MongoId($postId)),array('$pull'=>array('comments'=>array('_id'=>new MongoId($commentId))),'$inc'=>array('commentCount'=>-1)));
    } catch (Exception $e) {
        echo "error removing comment from post in collection";
        return false;
    }
    return true;
}

function unlikePost($collection, $postId, $likeUserId, $userId) {
    if ($likeUserId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->$collection->findOne(array('_id'=>new MongoId($postId),'likes._id'=>new MongoId($userId)));
        if (count($result) < 1) {
            echo "here";
            return false;
        }
    } catch (Exception $e) {
        echo "error checking if user has liked the post before removing";
        return false;
    }
    try {
        $result = $db->$collection->update(array('_id'=>new MongoId($postId)),array('$pull'=>array('likes'=>array('_id'=>new MongoId($userId))),'$inc'=>array('likeCount'=>-1)));
    } catch (Exception $e) {
        echo "error removing like from likes";
        return false;
    }
    return true;
}
function undislikePost($collection, $postId, $likeUserId, $userId) {
    if ($likeUserId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->$collection->findOne(array('_id'=>new MongoId($postId),'dislikes._id'=>new MongoId($userId)));
        if (count($result) < 1) {
            return false;
        }
    } catch (Exception $e) {
        echo "error checking if user has liked the post before removing";
        return false;
    }
    try {
        $result = $db->$collection->update(array('_id'=>new MongoId($postId)),array('$pull'=>array('dislikes'=>array('_id'=>new MongoId($userId))),'$inc'=>array('dislikeCount'=>-1)));
    } catch (Exception $e) {
        echo "error removing like from likes";
        return false;
    }
    return true;
}
function unlikeComment($collection, $postId, $commentId, $commentLikeUserId, $userId) {
    if ($commentLikeUserId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->$collection->update(array('_id'=>new MongoId($postId),'comments.likes._id'=>new MongoId($userId)),array('$pull'=>array('comments.$.likes'=>array('_id'=>new MongoId($userId)))));
    } catch (Exception $e) {
        echo "error removing like from comment likes";
        print_r($e);
        return false;
    }
    return true;
}

function undislikeComment($collection, $postId, $commentId, $commentLikeUserId, $userId) {
    if ($commentLikeUserId !== $userId) {
        return false;
    }
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->$collection->update(array('_id'=>new MongoId($postId),'comments.dislikes._id'=>new MongoId($userId)),array('$pull'=>array('comments.$.dislikes'=>array('_id'=>new MongoId($userId)))));
    } catch (Exception $e) {
        echo "error removing like from comment likes";
        print_r($e);
        return false;
    }
    return true;
}


    

?>


