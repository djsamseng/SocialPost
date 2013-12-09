<?php

function connect() {
    $connection = new MongoClient();
    $db = $connection->socialpost;
    return $db;
}

function login($email,$password) {
    $db = connect();
    $query = array("email"=>$email);
    $cursor = $db->users->find($query);
    $ar = $cursor->getNext();
    if ($ar["password"]==$password) {
        return array("auth"=>true,"id"=>(string)$ar["_id"],"firstname"=>$ar["firstname"],"lastname"=>$ar["lastname"]);
    } else {
        return array("auth"=>false,"id"=>"0");
    }
}

function create($email,$password,$firstname,$lastname) {
    $db = connect();
    $new = array("email"=>$email,"password"=>$password,"firstname"=>$firstname,"lastname"=>$lastname);
    try {
        $result = $db->users->insert($new,array('w'=>true));
    } catch(Exception $e) {
        return array("auth"=>false,"id"=>"0");
    }
    if (isset($result) && $result["ok"] == 1) {
        return login($email,$password);
    } else {
        return array("auth"=>false,"id"=>"0");
    }
}
?>
