<?php
require_once('mongodatabase.php');

function searchAll($userid,$search,$limit=10) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $cursor = $db->users->find(
            array(
                '$or'=>array(
                    array("firstname"=>new MongoRegex("/".$search."/i")),
                    array("lastname"=>new MongoRegex("/".$search."/i")),
                    array("email"=>new MongoRegex("/".$search."/i"))
                )
            ),
            array(
                "_id"=>1,
                "firstname"=>1,
                "lastname"=>1,
                "email"=>1,
            )
        )->limit($limit);
        $results=array();
        while ($cursor->hasNext()) {
            $results[]=($cursor->getNext());
        }
    } catch (Exception $e) {
        echo "error in search";
        print_r($e);
    }
    return $results;
}
?>
