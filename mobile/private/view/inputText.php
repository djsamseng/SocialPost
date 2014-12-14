    <?php render("header");?>
        <div data-role="page" id="inputText">
            <form onsubmit="newPostText(this);return false;" action="index.php?page=home" method="">
            <div data-role="header">
                <div style="float:right;">
                <input type="submit" value="Post">
                </div>
                <h1>Status</h1>
            </div>
            <div data-role="content" style="width: 90%;" id="contentInputText">
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
                <div id=newPostTextLocationDisplay">
                    <input readonly="readonly" value="" id="addNear" name="addNear">
                    <input readonly="readonly" value="" id="addLat" name="addLat">
                    <input readonly="readonly" value="" id="addLng" name="addLng">
                    <input readonly="readonly" value="" id="addRadius" name="addRadius">
                    <a onclick="clearNewPostTextLocationDisplay(); return false">Clear Location</a>
                </div>
            </div>
            </form>
            <a href="index.php?page=main&action=addLocation&from=home" data-rel="dialog">Add Location</a>
        </div>
    </body>
</html>
                
