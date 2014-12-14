            <?php $profpicurl = "../private/model/pictures/".$_SESSION["id"]."/profilepictures/".getProfilePictures($_SESSION["id"],$_SESSION["id"]);?>
            <div id="lpanel" class="<?php if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'lpanelbodyfixedhidden';}else{echo 'lpanelbodyfixed';}?>">
                <a id="lpanellink" href="index.php?action=sitetoggle&feedtype=<?php echo $feedtype;?>&inputstate=<?php echo $input;?>">
                <div class="lpanelbodylink" style="<?php if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'height: 50px;';}else{echo 'height: 300px;';}?>">
                </div>
                </a>
                <div id="lpanelbody" class="lpanelbody" style="<?php if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'height: 50px;';}else{echo 'height: 300px;';}?>">
                    <a href="index.php">
                        <div class="leftpanelpicholder">
                            SocialPost
                        </div>
                    </a>
                    <a href="#">
                        <div class="leftpanelpicholder">
                            Facebook
                        </div>
                    </a>
                    <a href="#">
                        <div class="leftpanelpicholder">
                            Twitter
                        </div>
                    </a>
                    <a href="#">
                        <div class="leftpanelpicholder">
                            Tumblr
                        </div>
                    </a>
                </div>
            </div>
            <div class="leftbody" style="<?php //if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'visibility: visible;';}else{echo 'visibility: hidden;';}?>">
                <div class="leftinfo">
                    <div class="leftpicholder">
                        <img class="leftpic" src="<?php echo $profpicurl;?>">
                    </div>
                    <div class="leftuserinfo">
                        <a class="leftuserinfotext" href="profile.php?id=<?php echo $_SESSION["id"];?>">
                        <span style="text-decoration:underline"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'];?></span><br>
                        View Profile
                        </a>
                    </div>
                    <div class="clear">
                    </div>
                    <div class="leftusersubinfo">
                        <a class="leftuserinfotext" href="profile.php?id=<?php echo $_SESSION["id"];?>&subpage=postsSubpage">Posts</a><br>
                        <a class="leftuserinfotext" href="profile.php?id=<?php echo $_SESSION["id"];?>&subpage=friendsSubpage">Friends</a><br>
                        Requests
                    </div>
                </div>
                <div class="leftinfo">
                    <div id="leftlocation">
                    </div>
                </div>
            </div>
