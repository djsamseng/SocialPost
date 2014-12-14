<?php 
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
$_SESSION["lastPage"] = "messages";
render("messages",array());
?>
