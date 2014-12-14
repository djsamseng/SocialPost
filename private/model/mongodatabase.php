<?php

function connect() {
    try {
        $connection = new MongoClient();
        $db = $connection->socialpost;
    } catch (exception $e) {
        return null;
    }
    return $db;
}

function login($email,$password) {
    //sleep(1);//prevent rapid login attemps
    $db = connect();
    if ($db == null) {
        return array("auth"=>false,"id"=>"0","er"=>"Could not connect to DB");
    }
    $query = array("email"=>$email);
    $cursor = $db->users->find($query);
    $ar = $cursor->getNext();
    if ($ar["password"]==$password) {
        return array("auth"=>true,"id"=>(string)$ar["_id"],"firstname"=>$ar["firstname"],"lastname"=>$ar["lastname"]);
    } else {
        return array("auth"=>false,"id"=>"0","er"=>"Incorrect");
    }
}

function create($email,$password,$firstname,$lastname) {
    //sleep(1);//prevent bot creating accounts too fast
    $db = connect();
    if ($db == null) {
        return array("auth"=>false,"id"=>"0","er"=>"Could not connect to DB");
    }
    $new = array(
        "email"=>$email,
        "password"=>$password,
        "firstname"=>$firstname,
        "lastname"=>$lastname,
        "posts"=>array(),
        "messages"=>array(),
        "friends"=>array(),
        "pictures"=>array("profilepictures"=>array(),"mobilePhotos"=>array()),
        "requests"=>array("friendRequests"=>array()),
        "requestsMade"=>array("friendRequestsMade"=>array())
    );
    //unqiue indexes - email, _id
    //friendRequests and friendRequestsMade need to be sets
    try {
        $result = $db->users->insert($new,array('w'=>true));
    } catch (Exception $e) {
        return array("auth"=>false,"id"=>"0");
    }
    if (isset($result) && $result["ok"] == 1) {
        $newlogin = login($email,$password);
        $result2 = mkdir($_SERVER["DOCUMENT_ROOT"]."/SocialPostCurrent/private/model/pictures/".$newlogin['id']."/profilepictures",0777,true);
        mkdir($_SERVER["DOCUMENT_ROOT"]."/SocialPostCurrent/private/model/pictures/".$newlogin['id']."/mobilePhotos",0777,true);
        return $newlogin;
    } else {
        return array("auth"=>false,"id"=>"0");
    }
}
function getProfileInfo($userId,$profileId) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $cursor = $db->users->findOne(array('_id'=>new MongoId($profileId)),array('firstname'=>1,'lastname'=>1));
        return $cursor;
    } catch (Exception $e) {
        return null;
    }
    return $results;
}
?>


