    <?php render("header");?>
        <div data-role="page" id="home">
            <div data-role="header">
                <h1>SocialPost</h1>
                <a href="?page=main&action=logout" id="homeLogout">Logout</a>
            </div>
            <div data-role="content" id="contentMessages">
                Messages
            </div>
            <div data-role="footer" data-position="fixed" data-id="footer">
                <a href="index.php?page=home" id="footerFeedLink">Feed</a>
                <a href="index.php?page=profile" id="footerProfileLink">Profile</a>
                <a href="index.php?page=messages" id="footerMessagesLink">Messages</a>
                <a href="index.php?page=search" id="footerSearchLink">Search</a>
            </div>
        </div>
    </body>
</html>

