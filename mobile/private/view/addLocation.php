    <?php render("header");?>
        <div data-role="page" id="addLocation">
            <form onsubmit="newPostTextAddLocation(); return false;" action="" method="">
            <div data-role="header">
                <div style="float:right;">
                <input type="submit" value="Add">
                </div>
                <h1>My Location</h1>
            </div>
            <div data-role="content" style="width: 90%;">
                <a onclick="getLocation(); return false;" href="#">Use My Location</a>
                <div id="myLocationNear">
                    <?php if (isset($near)) {
                        echo $near;
                    }?>
                </div>
                <div id="myLocationMap">
                    Map
                </div>
                <label for="addLocationRadius">Radius</label>
                <input type="range" min="0" max="13" onchange="changeCircleRadius(this)" id="addLocationRadius">
                <label for="addLocationRadiusDisplay"></label>
                <input type="text" id="addLocationRadiusDisplay">
            </div>
            </form>
        </div>
    </body>
</html>
