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
?>
