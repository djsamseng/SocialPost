<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css">
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>-->
        <link rel="stylesheet" href="../../../jquery.mobile-1.4.0/jquery.mobile-1.4.0.min.css">
        <script src="../../../jquery.mobile-1.4.0/jquery-1.9.1.min.js"></script>
        <script src="../../../jquery.mobile-1.4.0/jquery.mobile-1.4.0.min.js"></script>
        <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqztzPBx7b8KdCxTBCLXlXgl1IVrbq3zM&sensor=false"></script>-->
        <link rel="stylesheet" href="../private/view/Home/newhomestyle.css">
        <script>var lastPage; lastPage = "<?php if (isset($_SESSION["lastPage"])){echo $_SESSION["lastPage"];}else{echo "home";}?>";</script>
        <script src="mainjs.js"></script>
    </head>
    <body>
        <div data-role="page" id="mainHome">
            <div data-role="header">
                <h1>SocialPost</h1>
                <a href="#" id="homeLogout">Logout</a>
            </div>
            <div data-role="content" id="contentHome">
            </div>
            <div data-role="footer" data-position="fixed">
                <a id="footerFeedLink">Feed</a>
                <a id="footerProfileLink">Profile</a>
                <a id="footerMessagesLink">Messages</a>
                <a id="footerSearchLink">Search</a>
            </div>
        </div>
    </body>
</html>
