<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/searchdb.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');
$_SESSION["lastPage"] = "search";

if (isset($_POST["action"])) {
    $action = htmlspecialchars($_POST["action"]);
    if ($action == "search" && isset($_POST["searchText"])) {
        $searchText = htmlspecialchars($_POST["searchText"]);
        if (strlen($searchText) > 0) {
            $searchResults = searchAll($_SESSION["id"],$searchText,10);
            for ($i=0;$i<count($searchResults);$i++) {
                $searchResults[$i]["profPicUrl"]='../../private/model/pictures/'.$searchResults[$i]['_id']->{'$id'}.'/profilepictures/'.getProfilePictures($_SESSION["id"],$searchResults[$i]['_id']->{'$id'});
            }
            render("searchPosts",array("searchResults"=>$searchResults));
        }
    }
    exit;
} else {
    render("search",array());
}
?>
