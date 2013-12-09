<?php
require_once('includes/helper.php');
if (isset($_SESSION["id"]) && $_SESSION["id"] > 0 && isset($_SESSION["auth"]) && $_SESSION["auth"] == true) {
    render("home");
} else {
    render('login');
}
?>
