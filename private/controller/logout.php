<?php
require($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');
unset($_SESSION['userId']);
$_SESSION["auth"] = false;
session_destroy();
render("logout");
?>
