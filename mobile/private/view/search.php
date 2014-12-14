    <?php render("header");?>
        <div data-role="page" id="search">
            <div data-role="header">
                <h1>SocialPost</h1>
                <a href="?page=main&action=logout" id="homeLogout">Logout</a>
            </div>
        <div data-role="content" id="contentSearch">
            <form onsubmit="search(this); return false;" action="#" method="post">
                <label for="footerSearch">Search</label>
                <input type="search" name="footerSearch" id="footerSearch" value="" />
                <input type="submit" value="Search" />
            </form>
            <div id="searchContent">
            </div>
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

