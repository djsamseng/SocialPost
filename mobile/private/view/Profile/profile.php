<?php render("header");?>
    <div data-role="page" id="profile">
        <div data-role="header">
            <h1>SocialPost</h1>
            <a href="?page=main&action=logout" id="homeLogout">Logout</a>
        </div>
        <div data-role="content" id="contentProfile">
            <div id="profileprofpicholder">
                <div class="profileprofpic">
                    <img class="friend-pic-thumb" src="<?php echo $profPicUrl;?>"></img>
                </div>
                <div class="profileprofsubinfo">
                    <?php
                        echo $profileInfo["firstname"]." ".$profileInfo["lastname"];
                    ?>
                    <div id="friendStatus">
                        <?php 
                            if ($friendStatus == "friends") {
                                echo "<br>Friends";
                            } else if ($friendStatus == "pending") {
                        ?>
                                <form onsubmit="removeFriendRequest(this); return false;" method="post" action="">
                                    <input readonly="readonly" name="profileId" value="<?php echo $profileId;?>" style="display:none;">
                                    <input type="submit" value="Friends Pending">
                                </form>
                        <?php
                            } else if ($friendStatus == "accept") {
                                ?><br>
                                <form onsubmit="acceptFriend(this); return false;" method="post" action="">
                                    <input readonly="readonly" name="profileId" value="<?php echo $profileId;?>" style="display:none">
                                    <input type="submit" value="Accept Friend">
                                </form><?php
                            } else if ($friendStatus == "add"){
                                ?><br>
                                <form onsubmit="addFriend(this); return false;" method="post" action="">
                                    <input readonly="readonly" name="profileId" value="<?php echo $profileId;?>"; style="display:none">
                                    <input type="submit" value="Add Friend">
                                </form><?php
                            }?>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
            <div class="profsubinfo">
                <a onclick="renderProfilePosts('<?php echo $profileId;?>',true,false); return false;" href="#">
                    <button type="button" style="width: 23%;float:left;">Posts</button>
                </a>
                <a onclick="renderProfileInfo('<?php echo $profileId;?>'); return false;" href="#">
                    <button type="button" style="width: 23%;float:left;">Info</button>
                </a>
                <a onclick="renderProfilePhotos('<?php echo $profileId;?>'); return false;" href="#">
                    <button type="button" style="width: 23%;float:left;">Photos</button>
                </a>
                <a onclick="renderProfilePlaces('<?php echo $profileId;?>'); return false;" href="#">
                    <button type="button" style="width: 23%;float:left;">Places</button>
                </a>
                <a onclick="renderProfileFriends('<?php echo $profileId;?>'); return false;" href="#">
                    <button type="button" style="width: 23%;float:left;">Friends</button>
                </a>
                <div class="clear">
                </div>
            </div>
            <div id="profileContent">
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
