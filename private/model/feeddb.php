<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
//require_once('../private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
//require_once('../private/model/picturedb.php');

function getProfilePosts($id,$profileId,$firstpostdate=null,$lastpostdate=null,$loadbottom=false,$mylong=1,$mylat=1,$numberOfPosts=10) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    if (!($mylong > -90 && $mylong < 90 && $mylat > -90 && $mylat < 90)) {
        $mylong = 1;
        $mylat = 1;
    }
    date_default_timezone_set('EST');
    if ($lastpostdate != null && $loadbottom) { //get posts after lastpostdate
        /*try {
            $mylocquery = array('$geoIntersects'=>array('$geometry'=>array('type'=>'Polygon','coordinates'=>array(array(array($mylong-0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat-0.00001))))));
            $result = $db->users->aggregate(array(
                array('$match'=>array('_id'=>array('$in'=>$friendObjs))),
                array('$unwind'=>'$posts'),
                array('$match'=>array('posts.loc'=>$mylocquery,'posts.expiration'=>array('$gte'=>new MongoDate()),'posts.date'=>array('$lt'=>new MongoDate($lastpostdate)))),
                array('$project'=>array('posts'=>1,'firstname'=>1,'lastname'=>1)),
                array('$sort'=>array('posts.date'=>-1)),
                array('$limit'=>$numberOfPosts)
            ));
        } catch (Exception $e) {
            echo "error getting friends' posts";
            return null;
        }*/
        return null;
    } else { //get first ten posts
        try {
            $mylocquery = array('$geoIntersects'=>array('$geometry'=>array('type'=>'Polygon','coordinates'=>array(array(array($mylong-0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat-0.00001))))));
            $result = $db->users->aggregate(array(
                array('$match'=>array('_id'=>new MongoId($profileId))),
                array('$unwind'=>'$posts'),
                array('$match'=>array('posts.loc'=>$mylocquery,'posts.expiration'=>array('$gte'=>new MongoDate()))),
                array('$project'=>array('posts'=>1,'firstname'=>1,'lastname'=>1)),
                array('$sort'=>array('posts.date'=>-1)),
                array('$limit'=>$numberOfPosts)
            ));
        } catch (Exception $e) {
            echo "error getting friends' posts";
            return null;
        }
    }
    try {
        $finalresults=array();
        for ($i=0;$i<count($result['result']);$i++) {
            $finalresults[$i] = $db->$result['result'][$i]['posts']['collection']->findOne(array('_id'=>$result['result'][$i]['posts']['_id']));
            $profPic = "../private/model/pictures/".$result['result'][$i]['posts']['userId']->{'$id'}."/profilepictures/".getProfilePictures($id,$result['result'][$i]['posts']['userId']->{'$id'});
            $postersinfo = getProfileInfo($id,$result['result'][$i]['posts']['userId']->{'$id'});
            $finalresults[$i]['profPicUrl']=$profPic;
            $finalresults[$i]['firstname']=$postersinfo['firstname'];
            $finalresults[$i]['lastname']=$postersinfo['lastname'];
        }
    } catch (Exception $e) {
        echo "error getting text of friends' posts";
        return null;
    }
    return $finalresults;
}


function getWorldFeed($limit=20,$firstpostdate=null,$lastpostdate=null,$loadbottom=false) {
    $feeddata = getWorldPosts("world",$limit);
    for ($i=0;$i<count($feeddata);$i++) {
        $info = getProfileInfo("",$feeddata[$i]['userId']->{'$id'});//need to replace "" with id which should be $_SESSION["id"] except in login page
        $profpic = getProfilePictures("",$feeddata[$i]['userId']->{'$id'});// same here
        $feeddata[$i]["firstname"]=$info["firstname"];
        $feeddata[$i]["lastname"]=$info["lastname"];
        $feeddata[$i]["profPicUrl"]="../private/model/pictures/".$feeddata[$i]['userId']."/profilepictures/".$profpic;
    }
    return $feeddata;
}

function getWorldPosts($type,$limit=20) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    if ($type == "world") {
        try {
            $cursor = $db->world->find(array('expiration'=>array('$gte'=>new MongoDate())))->limit($limit);
            $ar = array();
            $cursor->sort(array("date"=>-1));
            while ($cursor->hasNext()) {
                $ar[]=$cursor->getNext();
            }
        }
        catch (exception $e) {
            return null;
        }
        return $ar;
    } else {
        return null;
    } 
}


function getFriendsFeed($id,$firstpostdate=null,$lastpostdate=null,$loadbottom=false,$mylong=1,$mylat=1,$numberOfPosts=10) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    if (!($mylong > -90 && $mylong < 90 && $mylat > -90 && $mylat < 90)) {
        $mylong = 1;
        $mylat = 1;
    }
    try {
        $friends = $db->users->findOne(array('_id'=>new MongoId($id)),array('friends._id'=>1,'_id'=>0));
    } catch (Exception $e) {
        echo "error getting friends";
        return null;
    }
    $friendObjs = array();
    foreach ($friends['friends'] as $friendAr) {
        $friendObjs[] = $friendAr['_id'];
    }
    $friendObjs[]=new MongoId($id);
    date_default_timezone_set('UTC');
    if ($lastpostdate != null && $loadbottom) { //get posts after lastpostdate
        try {
            $mylocquery = array('$geoIntersects'=>array('$geometry'=>array('type'=>'Polygon','coordinates'=>array(array(array($mylong-0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat-0.00001))))));
            $result = $db->users->aggregate(array(
                array('$match'=>array('_id'=>array('$in'=>$friendObjs))),
                array('$unwind'=>'$posts'),
                array('$match'=>array('posts.loc'=>$mylocquery,'posts.expiration'=>array('$gte'=>new MongoDate()),'posts.date'=>array('$lt'=>new MongoDate($lastpostdate)))),
                array('$project'=>array('posts'=>1,'firstname'=>1,'lastname'=>1)),
                array('$sort'=>array('posts.date'=>-1)),
                array('$limit'=>$numberOfPosts)
            ));
        } catch (Exception $e) {
            echo "error getting friends' posts";
            return null;
        }
    } else { //get first ten posts
        try {
            $mylocquery = array('$geoIntersects'=>array('$geometry'=>array('type'=>'Polygon','coordinates'=>array(array(array($mylong-0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat-0.00001),array($mylong+0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat+0.00001),array($mylong-0.00001,$mylat-0.00001))))));
            $result = $db->users->aggregate(array(
                array('$match'=>array('_id'=>array('$in'=>$friendObjs))),
                array('$unwind'=>'$posts'),
                array('$match'=>array('posts.loc'=>$mylocquery,'posts.expiration'=>array('$gte'=>new MongoDate()))),
                array('$project'=>array('posts'=>1,'firstname'=>1,'lastname'=>1)),
                array('$sort'=>array('posts.date'=>-1)),
                array('$limit'=>$numberOfPosts)
            ));
        } catch (Exception $e) {
            echo "error getting friends' posts";
            return null;
        }
    }
    try {
        $finalresults=array();
        for ($i=0;$i<count($result['result']);$i++) {
            $finalresults[$i] = $db->$result['result'][$i]['posts']['collection']->findOne(array('_id'=>$result['result'][$i]['posts']['_id']));
            $profPic = "../private/model/pictures/".$result['result'][$i]['posts']['userId']->{'$id'}."/profilepictures/".getProfilePictures($id,$result['result'][$i]['posts']['userId']->{'$id'});
            $postersinfo = getProfileInfo($id,$result['result'][$i]['posts']['userId']->{'$id'});
            $finalresults[$i]['profPicUrl']=$profPic;
            $finalresults[$i]['firstname']=$postersinfo['firstname'];
            $finalresults[$i]['lastname']=$postersinfo['lastname'];
            $hasLiked = $db->$result['result'][$i]['posts']['collection']->findOne(array('_id'=>$result['result'][$i]['posts']['_id'],'likes._id'=>new MongoId($id)),array('_id'=>1));
            if (isset($hasLiked['_id'])) {
                $finalresults[$i]['hasLiked']=true;
            }
            $hasDisliked = $db->$result['result'][$i]['posts']['collection']->findOne(array('_id'=>$result['result'][$i]['posts']['_id'],'dislikes._id'=>new MongoId($id)),array('_id'=>1));
            if (isset($hasDisliked['_id'])) {
                $finalresults[$i]['hasDisliked']=true;
            }
        }
    } catch (Exception $e) {
        echo "error getting text of friends' posts";
        return null;
    }
    return $finalresults;
}

function getUpdatedPost($collection, $postId, $id) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $result = $db->$collection->findOne(array('_id'=>new MongoId($postId)));
    } catch (Exception $e) {
        echo "error getting updated post";
        return null;
    }
    try {
        $hasLiked = $db->$collection->findOne(array('_id'=>new MongoId($postId),'likes._id'=>new MongoId($id)),array('_id'=>1));
        $hasDisliked = $db->$collection->findOne(array('_id'=>new MongoId($postId),'dislikes._id'=>new MongoId($id)),array('_id'=>1));
    } catch (Exception $e) {
        echo "error checking if user has liked";
        return null;
    }
    if (isset($hasLiked['_id'])) {
        $result['hasLiked']=true;
    }
    if (isset($hasDisliked['_id'])) {
        $result['hasDisliked']=true;
    }
    $result['profPicUrl']=getProfilePictures($id,$result['userId']->{'$id'});
    $postersInfo = getProfileInfo($id,$result['userId']->{'$id'});
    $result['firstname']=$postersInfo['firstname'];
    $result['lastname']=$postersInfo['lastname'];
    return array($result);
}


/*
function getFriendsFeedold($id,$firstpostdate=null,$lastpostdate=null,$loadbottom=false,$mylong=1,$mylat=1,$limit=20,$postsPerFriend=100) {
    //Need to change limit and posts per friends system to probably an aggregation system
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $friends = $db->users->findOne(array('_id'=>new MongoId($id)),array('friends'=>1,'_id'=>0));
    } catch (Exception $e) {
        echo "error getting friends";
        return null;
    }
    $friends['friends'][]=array('_id'=>new MongoId($id),'date'=>new MongoDate());
    date_default_timezone_set('UTC');
    try {
        $results = array();
        foreach ($friends['friends'] as $friend) {
            $mylocquery = array('$geoIntersects'=>array('$geometry'=>array('type'=>'Polygon','coordinates'=>array(array(array($mylong,$mylat),array($mylong,$mylat+0.0001),array($mylong+0.0001,$mylat+0.0001),array($mylong+0.0001,$mylat),array($mylat,$mylong))))));
            $result = $db->users->aggregate(array(
                array('$match'=>array('_id'=>new MongoId($friend["_id"]))),
                array('$unwind'=>'$posts'),
                array('$match'=>array('posts.loc'=>$mylocquery,'posts.expiration'=>array('$gte'=>new MongoDate()))),
                array('$project'=>array('posts'=>1,'firstname'=>1,'lastname'=>1)),
                array('$sort'=>array('posts.date'=>-1)),
                array('$limit'=>$postsPerFriend)
            ));
            $j = 0;
            for ($i=0;$i<count($results);$i++) {
                if (count($result["result"])==0 || count($result["result"])==$j) {
                    break;
                }
                if ($result["result"][$j]["posts"]["date"]->sec > $results[$i]["posts"]["date"]->sec) {
                    array_splice($results,$i,0,array($result["result"][$j]));
                    $j++;
                }
            }
            while ($j < count($result["result"])) {
                $results[]=$result["result"][$j];
                $j++;
            }
        }
    } catch (Exception $e) {
        echo "error getting friends' posts";
        return null;
    }
    $results = array_slice($results,0,$limit);
    try {
        $finalresults=array();
        for ($i=0;$i<count($results);$i++) {
            $finalresults[$i] = $db->$results[$i]['posts']['collection']->findOne(array('_id'=>$results[$i]['posts']['_id']));
            $profPic = "../private/model/pictures/".$results[$i]['posts']['userId']->{'$id'}."/profilepictures/".getProfilePictures($id,$results[$i]['posts']['userId']->{'$id'});
            $postersinfo = getProfileInfo($id,$results[$i]['posts']['userId']->{'$id'});
            $finalresults[$i]['profPicUrl']=$profPic;
            $finalresults[$i]['firstname']=$postersinfo['firstname'];
            $finalresults[$i]['lastname']=$postersinfo['lastname'];
        }
    } catch (Exception $e) {
        echo "error getting text of friends' posts";
        return null;
    }
    return $finalresults;
}
*/
?>


