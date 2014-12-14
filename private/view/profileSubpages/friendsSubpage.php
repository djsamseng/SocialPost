<div class="allposts">
    <h2>Friends</h2>
    <div class="friendshold">
    <?php
    foreach ($friends as $friend) {
        ?>
        <div class="friendbox">
        <a class="friendnamelink" href="profile.php?id=<?php echo $friend['friends']['id'];?>">
            <span class="friendname">
                <?php echo $friend["firstname"]." ".$friend["lastname"];
                ?>
            </span>
            <div class="friend-pic-thumb-holder">
                <img class="friend-pic-thumb" src="<?php echo $friend['profPicUrl'];?>"></img>
            </div>
        </a>
        </div>
        <?php
    }
    ?>
    </div>
</div>

