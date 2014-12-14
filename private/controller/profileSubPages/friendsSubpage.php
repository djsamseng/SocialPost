<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/frienddb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');

function renderSubpage($info,$profposts,$profpicurl) {
    $friends = getFriends($_SESSION["id"],$info["_id"]->{'$id'});
    for ($i=0;$i<count($friends);$i++) {
        $info = getProfileInfo($_SESSION["id"],$friends[$i]['friends']['id']);
        $profpic = getProfilePictures($_SESSION["id"],$friends[$i]['friends']['id']);
        $friends[$i]["firstname"] = $info["firstname"];
        $friends[$i]["lastname"] = $info["lastname"];
        $friends[$i]["profPicUrl"] = "../private/model/pictures/".$friends[$i]['friends']['id']."/profilepictures/".$profpic;
    }
    render("profileSubpages/friendsSubpage",array("info"=>$info,"profposts"=>$profposts,"friends"=>$friends));
}


