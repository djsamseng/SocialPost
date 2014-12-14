            <div id="lpanel" class="<?php if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'lpanelbodyfixedhidden';}else{echo 'lpanelbodyfixed';}?>">
                <a id="lpanellink" href="index.php?page=messages&action=sitetoggle&messageid=<?php echo $messageid;?>">
                <div class="lpanelbodylink" style="<?php if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'height: 50px;';}else{echo 'height: 300px;';}?>">
                </div>
                </a>
                <div id="lpanelbody" class="lpanelbody" style="<?php //if (isset($_SESSION["sitetoggle"]) && !($_SESSION["sitetoggle"])) {echo 'height: 50px;';}else{echo 'height: 300px;';}?>">
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
                    <a href="profile.php?id=<?php echo $_SESSION['id']?>">
                        <div class="leftpicholder">
                            <img class="leftpic" src="<?php echo $profpicurl;?>">
                        </div>
                    </a>
                    <div class="leftuserinfo">
                        <a class="leftuserinfotext" href="profile.php?id=<?php echo $_SESSION['id'];?>">
                        <span style="text-decoration:underline"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'];?></span><br>
                        View Profile
                        </a>
                    </div>
                    <div class="clear">
                    </div>
                </div>
                <div class="leftinfo">
                    <a style="color: #3399FF;" href="index.php?page=messages">
                     Conversations
                    </a>
                    <?php 
                    foreach ($allMessages as $message) {
                    ?>
                        <a href="index.php?page=messages&type=message&messageid=<?php echo $message['_id']->{'$id'};?>">
                        <div class="lefteachholder">
                            <div class="lefteachnames">
                            <?php /*if (isset($message['users'][1]) && $message['users'][1]['_id']->{'$id'} != $id) {
                                    echo $message['users'][1]['firstname']." ".$message['users'][1]['lastname'];
                                } else {
                                    echo $message['users'][0]['firstname']." ".$message['users'][0]['lastname'];
                                }*/
                                foreach ($message['users'] as $user) {
                                    echo $user['firstname']." ".$user['lastname'];
                                }
                            ?>
                            </div>
                            <div class="lefteachpic">
                                <img class="post-pic-thumb" src="<?php echo $message['messages'][count($message['messages'])-1]['text'];?>"></img>
                            </div>
                            <div class="lefteachtext">
                                <?php echo $message['messages'][count($message['messages'])-1]['text'];?>
                            </div>
                            <div class="clear">
                            </div>
                        </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        
