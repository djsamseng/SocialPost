<?php
require_once('includes/helper.php');
require_once('../private/model/mongodatabase.php');
require_once('../private/model/frienddb.php');
require_once('../private/model/picturedb.php');
require_once('../private/model/searchdb.php');

$id = $_SESSION["id"];

$searchresults = null;
if (isset($_GET["search"])) {
    $search = htmlspecialchars($_GET["search"]);
    if (strlen($search) > 0) {
        $limit = 10;
        if (isset($_GET["limit"])) {
            $limit = htmlspecialchars($_GET["limit"]);
        }
        if ($limit < 1 || $limit > 100) {
            $limit = 10;
        }
        $searchresults = searchAll($id,$search,$limit);
        for ($i=0;$i<count($searchresults);$i++) {
            $searchresults[$i]["profPicUrl"]="../private/model/pictures/".$searchresults[$i]['_id']->{'$id'}."/profilepictures/".getProfilePictures($id,$searchresults[$i]['_id']->{'$id'});
        }
    }
}
$profpic = getProfilePictures($id,$id);
$requests = getRequests($id);
for ($i=0;$i<count($requests["friendRequests"]);$i++) {
    $info = getProfileInfo($id,$requests["friendRequests"][$i]["userId"]);
    $requests["friendRequests"][$i]["firstname"] = $info["firstname"];
    $requests["friendRequests"][$i]["lastname"] = $info["lastname"];
}

render("search",array("profpicurl"=>"../private/model/pictures/".$id."/profilepictures/".$profpic,"search"=>$search,"requests"=>$requests,"searchresults"=>$searchresults));
?>
