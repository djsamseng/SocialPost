<?php
require('includes/helper.php');
unset($_SESSION['userid']);
$_SESSION["auth"] = false;
session_destroy();
render("logout");
?>
