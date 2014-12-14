<?php 
render("header", array("title"=>"Profile","style"=>"Home/newhomestyle.css"));
?>
<div id="back">
    <?php render("bannerIn", array("name"=>$_SESSION['firstname']." ".$_SESSION['lastname']));?>
    <div id="close">
        <div id="profilemainleft">
            <div id="profileprofpicholder">
                <img class="profileprofpic" src=<?php echo $profpicurl;?> alt="Profile">
            </div>
            <div class="profileprofsubinfo">
                <?php
                    echo $info["firstname"]." ".$info["lastname"]."<br>";
                    if ($isFriend) {
                        echo "friends";
                    } else if ($isFriendPending) {
                        echo "friends pending";
                    } else if ($isFriendWaiting) {
                        $_SESSION["acceptFriend"] = $info['_id']->{'$id'};
                        ?>
                        <a href="profile.php?id=<?php echo $info['_id']->{'$id'};?>&action=acceptFriend">Accept Friend Request</a>
                        <?php
                    } else if (!$isOwn) {
                        $_SESSION["friendRequest"] = $info['_id']->{'$id'};
                        ?>
                        <a href="profile.php?id=<?php echo $info['_id']->{'$id'};?>&action=friendRequest">Add Friend</a>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div id="profilemaincenter">
            <div class="coverpicture">
                Cover Photo
            </div>
            <div class="profilemenu">
                <a href="?id=<?php echo $info['_id']->{'$id'};?>&subpage=postsSubpage"><button type="button" class="profmenuposts" style="<?php if (isset($_GET["subpage"])&&htmlspecialchars($_GET["subpage"])=="postsSubpage"){echo 'background-color:#FFFFFF';}?>">Posts</button></a>
                <a href="?id=<?php echo $info['_id']->{'$id'};?>&subpage=infoSubpage"><button type="button" class="profmenuinfo" style="<?php if (isset($_GET["subpage"])&&htmlspecialchars($_GET["subpage"])=="infoSubpage"){echo 'background-color:#FFFFFF';}?>">Info</button></a>
                <a href="?id=<?php echo $info['_id']->{'$id'};?>&subpage=photosSubpage"><button type="button" class="profmenuphotos" style="<?php if (isset($_GET["subpage"])&&htmlspecialchars($_GET["subpage"])=="photosSubpage"){echo 'background-color:#FFFFFF';}?>">Photos</button></a>
                <a href="?id=<?php echo $info['_id']->{'$id'};?>&subpage=friendsSubpage"><button type="button" class="profmenufriends" style="<?php if (isset($_GET["subpage"])&&htmlspecialchars($_GET["subpage"])=="friendsSubpage"){echo 'background-color:#FFFFFF';}?>">Friends</button></a>
            </div>
            <?php getSubpage($info,$profposts,$profpicurl);
            ?>

        </div>
        <div id="clear">
        </div>
    </div>
<div>
<?php render("footer")?>
