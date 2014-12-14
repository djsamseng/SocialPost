<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/homefunctions.php');


if (isset($_SESSION["id"]) && $_SESSION["id"] > 0 && isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    $feedtypes = getFeedType();
    $inputstate = getInputState();
    if (isset($_GET["action"])) {
        $action = htmlspecialchars($_GET["action"]);
        checkAction($action,$feedtypes["feedtype"],$inputstate);
    }
    $renderdata = array("id"=>$_SESSION["id"],"printfeed"=>$feedtypes["printfeed"],"feedtype"=>$feedtypes["feedtype"],"input"=>$inputstate,"numberOfPosts"=>getNumberOfPosts());
    render("Home/home",$renderdata);
} else {
    require_once('login.php');
    exit;
}

?>
