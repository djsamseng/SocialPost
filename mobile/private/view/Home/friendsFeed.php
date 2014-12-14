<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>-->
        <link rel="stylesheet" href="jquery.mobile-1.4.0/jquery.mobile-1.4.0.min.css">
        <script src="jquery.mobile-1.4.0/jquery-1.9.1.min.js"></script>
        <script src="jquery.mobile-1.4.0/jquery.mobile-1.4.0.min.js"></script>
        <script src="mainjs.js"></script>
        <link rel="stylesheet" href="../private/view/Home/newhomestyle.css">
    </head>
    <body>
        <div data-role="page" id="friendsfeed">
            <div data-role="header">
                <h1>SocialPost</h1>
                <a href="#" id="homeLogout">Logout</a>
            </div>
            <div data-role="content">
                <h2>Friends Feed</h2>
                <a href="#nearmefeed">Near Me Feed</a>
                <a href="#worldfeed">World Feed</a>
                <div id="friendsPosts">
                </div>
            </div>
            <div data-role="footer" data-position="fixed">
                <a href="index.php?page=home">Feed</a>
                <a href="index.php?page=profile">Profile</a>
            </div>
        </div>
    <body>
</html>

