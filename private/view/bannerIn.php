            <div class="banner-hold">
                <a href="index.php"><div class="banner-logo">Logo here</div></a>
                 <div class="banner-element">
                    <div class="banner-search">
                        <form action="index.php" method="get">
                            <input class="banner-search-input" type="text" name="search" placeholder="Search">
                            <input style="visibility:hidden" class="banner-search-submit" type="submit">
                            <input style="visibility:hidden" type="text" name="page" value="search">
                        </form>
                    </div>
                </div>
                <div class="banner-element">
                    <div class="feed">
                        <a href="index.php?page=home"><div class="dropdown-header">Feed</div></a>
                        <a class="drop" href="index.php?page=home">Feed Data</a>
                    </div>
                </div>
                <div class="banner-element">
                    <div class="messages">
                        <a href="index.php?page=messages"><div class="dropdown-header">Messages</div></a>
                        <a class="drop" href="index.php?page=messages">Message Data</a>
                    </div>
                </div>
                <div class="banner-element">
                    <div class="mapit">
                        <a href="#"><div class="dropdown-header">MapIt</div></a>
                        <a class="drop" href="#">Map Data</a>
                    </div>
                    <div id="locationinfo">
                        <div class="closeAddMapHolder">
                            <button id="closeAddMap" class="closeIcon">Close</button>
                        </div>
                        <div id="addmap">
                        </div>
                        <div id="newinputalltop" class="newinputall">
                            <div class="newinputbody">
                                <form onSubmit="return newPost(this);">
                                    <div class="textbody">
                                        <textarea id="newInputTextTop" name="newinputtext" class="newinputtext" cols="30"></textarea>
                                    </div>
                                    <div class="undertextbody">
                                        Expires In
                                        <select id="expireTimeTop" name="expireTime">
                                            <option name="fivemin">5 Minutes</option>
                                            <option name="onehour">2 Hours</option>
                                            <option name="oneday">1 Day</option>
                                            <option name="thirtydays">30 Days</option>
                                            <option name="oneyear">1 Year</option>
                                            <option name="never" selected="selected">Never</option>
                                        </select>
                                        Visibility
                                        <select id="postToTop" name="postTo">
                                            <option name="friends" selected="selected">Friends</option>
                                            <option name="nearme">Near Me</option>
                                            <option name="world">World</option>
                                        </select>
                                        Radius
                                        <input type="range" id="newRadius" name="newRadius" min="0" max="13"></input>
                                        <input type="text" id="newRadiusDisplay"></input>
                                        <input class="newinputsubmit" type="submit" value="Post"></input>
                                        <button type="button" id="addgetlocation" style="float:right;margin-right:100px;">Use My Location</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="banner-user">
                    <div class="user-options">
                        <a href="index.php?page=logout"><div class="dropdown-header">Logout</div></a>
                    </div>
                    <div class="user-profile">
                        <a href="profile.php?id=<?php echo $_SESSION["id"];?>"><div class="dropdown-header-profile"><?php if (isset($name)) {echo $name;}else{echo "Profile";}?></div></a>
                        <a class="drop" href="index.php">Home</a>
                        <a class="drop" href="profile.php?id=<?php echo $_SESSION["id"];?>">Profile</a>
                        <a class="drop" href="#">Settings</a>
                    </div>
                </div>
            </div>
