<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
function addProfilePicture($userId,$pictureId) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $results = $db->users->update(array('_id'=>new MongoId($userId)),array('$push'=>array('pictures.profilepictures'=>array('pictureId'=>$pictureId,'date'=>new MongoDate()))));
    } catch (Exception $e) {
        print_r($e);
        echo "ERR";
        return false;
    }
    return true;
}
function getProfilePictures($userId,$profileId) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $results = $db->users->aggregate(array(array('$match'=>array('_id'=>new MongoId($profileId))),array('$project'=>array('pictures.profilepictures'=>1)),array('$unwind'=>'$pictures.profilepictures'),array('$sort'=>array("pictures.profilepictures.date"=>-1)),array('$limit'=>1)));
    } catch (Exception $e) {
        return null;
    }
    if (count($results["result"])<1) {
        return null;
    }
    return $results["result"][0]["pictures"]["profilepictures"]["pictureId"]->{'$id'};
}
function uploadProfilePicture($userId,$picfile) {
    $allowed = array("jpeg","jpg","png","gif");
    $temp = explode(".",$picfile["name"]);
    $extension = end($temp);
    if ((($picfile["type"] == "image/gif") 
    || ($picfile["type"] == "image/jpeg")
    || ($picfile["type"] == "image/jpg")
    || ($picfile["type"] == "image/pjpeg")
    || ($picfile["type"] == "image/x-png")
    || ($picfile["type"] == "image/png"))
    && ($picfile["size"] < 50000)
    && in_array($extension, $allowed)) {
        if ($picfile["error"]>0) {
            echo "error ".$picfile["error"];//to be removed
            return false;
        } else {
            $picId=new MongoId();
            if (file_exists("../private/model/pictures/".$userId."/profilepictures/".$picId->{'$id'})) {
                echo "file already exists";//to be removed
                return false;
            } else {
                try {
                    $result = move_uploaded_file($picfile["tmp_name"],"../private/model/pictures/".$userId."/profilepictures/".$picId->{'$id'});
                } catch (Exception $e) {
                    echo "move error";
                    return false;
                }
                if ($result) {
                    $result2 = addProfilePicture($userId,$picId);
                    return $result2;
                }
                echo "result".$result;
                return false;
            }
        }
    } else {
        echo "Invalid file"; //to be removed
        return false;
    }
}


function uploadMobilePhoto($userId,$picfile) {
    //uploads to model/pictures/userId/mobilePhotos/
    $allowed = array("jpeg","jpg","png","gif");
    $temp = explode(".",$picfile["name"]);
    $extension = end($temp);
    if ((($picfile["type"] == "image/gif") 
    || ($picfile["type"] == "image/jpeg")
    || ($picfile["type"] == "image/jpg")
    || ($picfile["type"] == "image/pjpeg")
    || ($picfile["type"] == "image/x-png")
    || ($picfile["type"] == "image/png"))
    && ($picfile["size"] < 500000)
    && in_array($extension, $allowed)) {
        if ($picfile["error"]>0) {
            echo "error ".$picfile["error"];//to be removed
            return false;
        } else {
            $picId=new MongoId();
            if (file_exists($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/pictures/'.$userId.'/mobilePhotos/'.$picId->{'$id'})) {
                echo "file already exists";//to be removed
                return false;
            } else {
                try {
                    $result = move_uploaded_file($picfile["tmp_name"],$_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/pictures/'.$userId.'/mobilePhotos/'.$picId->{'$id'});
                } catch (Exception $e) {
                    echo "move error";
                    return false;
                }
                if ($result) {
                    if (addMobilePhoto($userId,$picId));
                    return $picId->{'$id'};
                }
                echo "result".$result;
                return false;
            }
        }
    } else {
        echo "Invalid file"; //to be removed
        return false;
    }
}

function addMobilePhoto($userId,$pictureId) {
    //Adds to user
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $results = $db->users->update(array('_id'=>new MongoId($userId)),array('$push'=>array('pictures.mobilePhotos'=>array('pictureId'=>$pictureId,'date'=>new MongoDate()))));
    } catch (Exception $e) {
        print_r($e);
        echo "ERR";
        return false;
    }
    return true;
}

?>


