<?php

$i = 0;
                date_default_timezone_set('EST');
                foreach ($feedData as $post) {
                    ?>
                    <div class="eachpostholder">
                        <span class="postdatesec" style="display:none"><?php echo $post["date"]->sec;?></span>
                        <div class="eachpostinside">
                            <?php if ($post['userId'] == $id) { /* ------- IF FROM HERE --------- */?>
                            <div class="postleftholderright">
                                <a onclick="link(this); return false;" class="postbynametext" href="index.php?page=profile&id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder-right">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?>
                                    </div>
                                </a>
                                <a onclick="link(this); return false;" href="index.php?page=post&postId=<?php echo $post['_id']->{'$id'};?>&collection=<?php echo $post['collection'];?>">
                                    Modify
                                </a>
                                <div class="clear">
                                </div>
                            </div>
                            <div class="postbodyleft">
                            <?php } else { /* --------- TO HERE ELSE ---------- */?>
                            <div class="postleftholder">
                                <a onclick="link(this); return false;" class="postbynametext" href="index.php?page=profile&id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?></div>
                                </a>
                            </div>
                            <div class="clear"></div>
                            <div class="postbody">
                            <?php } /* ----------- ENDS IF ELSE STATEMENT ---------- */?>
                                <div class="eachpost"><?php
                                    echo $post["text"];
                                    ?><br>
                                    <?php
                                    if (isset($post["picUrl"]) && strlen($post["picUrl"]) > 1) {?>
                                        <img src="<?php echo '../../../../SocialPostCurrent/private/model/pictures/'.$post['userId'].'/'.$post['picUrl'];?>"></img>
                                    <?php }?>
                                </div>
                                                                <div class="postbottomholder">
                                    <div class="postdateholder">
                                        <div class="postdate"><?php
                                            echo date('M d h:i a',$post["date"]->sec);
                                            ?>
                                        </div>
                                        <div class="expiredate">
                                            Expires<br>
                                            <?php echo date('M d, Y h:i a',$post["expiration"]->sec);?>
                                        </div>
                                    </div>
                                    <div class="postlocationholder">
                                        <?php if (isset($post["near"]) && strlen($post["near"]) > 0) {?>
                                        <div class="locationicon">
                                            Near <?php echo $post["near"];?>
                                        </div>
                                        <div class="locationholder">
                                        <div class="locationinfo">
                                            Please enable JavaScript to use this feature
                                            <?php //render("mapItWindow",array("num"=>count($feeddata),"iteration"=>$i));?>
                                        </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="commentactionholder">
                                        <form onsubmit="return likeAction(this);" name="likeaction" action="" method="post">
                                            <span name="likeCount">
                                            <?php
                                            if ($post["likeCount"] >= 1){
                                                echo $post["likeCount"];
                                            }?>
                                            </span>
                                            <input onclick="return likeClick(this)" type="submit" value="<?php if (isset($post['hasLiked'])){echo 'Unlike';}else{echo 'Like';}?>" name="like">
                                            <span name="dislikeCount">
                                            <?php if ($post["dislikeCount"] >= 1) {
                                                echo $post["dislikeCount"];
                                            }?>
                                            </span>
                                            <input onclick="return dislikeClick(this)" type="submit" value="<?php if (isset($post['hasDisliked'])){echo 'Undislike';}else{echo'Dislike';}?>" name="dislike">
                                            <input readonly="readonly" name="postid" style="display:none;" value="<?php echo $post['_id']->{'$id'};?>">
                                            <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                            <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="clear">
                            </div>
                        </div><!--ends eachpostinside-->
                    </div><!--ends eachpostholder-->
                    <?php
                    $i++;
                }/* -------------------- ENDS FOR EACH STATEMENT POSTS IN ALL POSTS ----------------------- */
                ?><!--ends feeddata-->
