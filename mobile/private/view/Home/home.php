    <?php render("header");?>
        <div data-role="page" id="home">
            <div data-role="header">
                <h1>SocialPost</h1>
                <a href="?page=main&action=logout" id="homeLogout">Logout</a>
            </div>
            <div data-role="content" id="contentHome">
                <div class="newinputselect">
                    <a href="index.php?page=main&action=statusDialog" data-rel="dialog">
                        <button type="button" style="width: 50%; float:left;">Status</button>
                    </a>
                    <a href="index.php?page=main&action=photoDialog" data-rel="dialog">
                        <button type="button" style="width: 50%; float:left;">Photo</button>
                    </a>
                        <div class="clear">
                        </div>
                </div>
                <form onchange="renderFeedType(this); return false;" action="" method="post">
                    <label for="feedSelect"></label>
                    <select name="feedSelect" id="feedSelect" data-mini="true">
                        <option value="Friends" selected="selected">Friends</option>
                        <option value="Near Me">Near Me</option>
                        <option value="World">World</option>
                    </select>
                </form>
                <form onsubmit="getLocation('#homeNear'); return false;" action="" method="post">
                    <input type="submit" value="Use My Location">
                </form>
                <div id="homeNear">
                <?php if (isset($near)) {
                    echo $near;
                }?>
                </div>
                <div id="friendsPosts">
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

