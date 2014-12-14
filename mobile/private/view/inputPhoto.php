    <?php render("header");?>
        <div data-role="page" id="inputPhoto">
            <form action="index.php?page=home&action=uploadMobilePhoto" method="post" data-ajax="false" enctype="multipart/form-data">
            <div data-role="header">
                <div style="float:right;">
                <input type="submit" value="Post">
                </div>
                <h1>Status</h1>
            </div>
            <div data-role="content" style="width: 90%;">
                <label for="uploadMobilePhoto">Select Photo</label>
                <input type="file" name="uploadMobilePhoto" id="uploadMobilePhoto">
                <label for="newText"></label>
                <textarea id="newText" name="newText"></textarea>
                <label for="expireTime">Expires</label>
                <select name="expireTime">
                    <option name="fivemin">5 Minutes</option>
                    <option name="twohour">2 Hours</option>
                    <option name="oneday">1 Day</option>
                    <option name="thirtydays">30 Days</option>
                    <option name="oneyear">1 Year</option>
                    <option name="never" selected="selected">Never</option>
                </select>
                <label for="postTo">Visibility</label>
                <select name="postTo">
                    <option name="friends" selected="selected">Friends</option>
                    <option name="nearme">Near Me</option>
                    <option name="world">World</option>
                </select>
                </form>
            </div>
        </div>
    </body>
</html>
