<?php
//print_r($feedData);

$i = 0;
                date_default_timezone_set('EST');
                foreach ($feedData as $post) {
                    ?>
                    <div class="eachpostholder">
                        <span class="postdatesec" style="display:none"><?php echo $post["date"]->sec;?></span>
                        <div class="eachpostinside">
                            <?php if ($post['userId'] == $id) { /* ------- IF FROM HERE --------- */?>
                            <div class="postleftholderright">
                                <a class="postbynametext" href="index.php?page=profile&id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?>
                                    </div>
                                </a>
                                <div class="optionsholder">
                                    <div class="optionslistholder">
                                        <div class="postoption">
                                            <form>
                                                <input type="submit" value="Edit" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                            </form>
                                        </div>
                                        <div class="postoption">
                                            <form onSubmit="return removePost(this)" action="" method="post">
                                                <input type="submit" value="Delete" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                                <input readonly="readonly" name="postid" style="display:none" value="<?php echo $post['_id']->{'$id'};?>">
                                                <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                                <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear">
                                </div>
                            </div>
                            <div class="postbodyleft">
                            <?php } else { /* --------- TO HERE ELSE ---------- */?>
                            <div class="postleftholder">
                                <a class="postbynametext" href="index.php?page=profile&id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?></div>
                                </a>
                                <div class="clear">
                                </div>
                            </div>
                            <div class="postbody">
                            <?php } /* ----------- ENDS IF ELSE STATEMENT ---------- */?>
                                <div class="eachpost"><?php
                                    echo $post["text"];
                                    ?>
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
                            <?php if ($post['userId'] == $id) {?>
                            <div class="commentsholderleft">
                            <?php } else {?>
                            <div class="commentsholder">
                            <?php }?>
                                <?php foreach ($post["comments"] as $comment) { /* ------------ FOR EACH STATEMENT ------------- */
                                    if ($comment['userId'] == $id) { /* ---------- IF STATEMENT FROM HERE ------------- */?>
                                        <a href="index.php?page=profile&id=<?php echo $comment['userId'];?>">
                                            <div class="eachcommentpicholderright">
                                                <img class="commentpic" src="<?php echo $comment['profPicUrl'];?>">
                                            </div>
                                        </a>
                                        <div class="eachcommentholderleft">
                                            <a style="color: #3399FF;" href="index.php?page=profile&id=<?php echo $comment['userId'];?>">
                                            <?php echo $comment["firstname"]." ".$comment["lastname"]?>
                                            </a>
                                        <?php
                                            echo " - ".$comment["text"];?>
                                            <div class="eachcommentlikeleft">
                                                <?php echo $comment["date"];?><br>
                                                <form onsubmit="return false;" name="likeaction" action="" method="post">
                                                    <?php if (count($comment["likes"])>0){echo count($comment["likes"]);}?>
                                                    <input type="submit" value="Like" name="like">
                                                    <?php if (count($comment["dislikes"])>0){echo count($comment["dislikes"]);}?>
                                                    <input type="submit" value="Dislike" name="dislike">
                                                    <input readonly="readonly" name="postid" style="display:none;" value="<?php echo $post['_id']->{'$id'};?>">
                                                    <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                                    <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                                    <input readonly="readonly" name="commentid" style="display:none" value="<?php echo $comment['_id']->{'$id'};?>">
                                                </form>
                                            </div>
                                            <div class="commentoptionsholder">
                                                <div class="optionslistholder">
                                                    <div class="postoption">
                                                        <form>
                                                            <input type="submit" value="Edit" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                                        </form>
                                                    </div>
                                                    <div class="postoption">
                                                        <form action="" method="post">
                                                            <input type="submit" value="Delete" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                                            <input readonly="readonly" name="postid" style="display:none" value="<?php echo $post['_id']->{'$id'};?>">
                                                            <input readonly="readonly" name="usercommentid" style="display:none" value="<?php echo $comment['userId']->{'$id'};?>">
                                                            <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                                            <input readonly="readonly" name="commentid" style="display:none" value="<?php echo $comment['_id']->{'$id'}?>">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <?php } else { /* -------------- TO HERE ELSE STATEMENT ---------------- */?>
                                                <a href="index.php?page=profile&id=<?php echo $comment['userId'];?>">
                                                    <div class="eachcommentpicholder">
                                                        <img class="commentpic" src="<?php echo $comment['profPicUrl'];?>">
                                                    </div>
                                                </a>
                                                <div class="eachcommentholder">
                                                        <a style="color: #3399FF;" href="index.php?page=profile&id=<?php echo $comment['userId'];?>">
                                                            <?php echo $comment["firstname"]." ".$comment["lastname"]?>
                                                        </a>
                                                        <?php
                                                            echo " - ".$comment["text"];?>
                                                    <div class="eachcommentlike">
                                                        <?php echo $comment["date"];?><br>
                                                        <form onsubmit="return false;" name="likeaction" action="" method="post">
                                                            <?php if (count($comment["likes"])>0){echo count($comment["likes"]);}?>
                                                            <input type="submit" value="Like" name="like">
                                                            <?php if (count($comment["dislikes"])>0){echo count($comment["dislikes"]);}?>
                                                            <input type="submit" value="Dislike" name="dislike">
                                                            <input readonly="readonly" name="postid" style="display:none;" value="<?php echo $post['_id']->{'$id'};?>">
                                                            <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                                            <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                                            <input readonly="readonly" name="commentid" style="display:none" value="<?php echo $comment['_id']->{'$id'};?>">
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php } /* ---------------- ENDS IF ELSE STATEMENT ----------------- */?>
                                            <div class="clear">
                                            </div>
                                    <?php
                                } /* ------------------ ENDS FOR EACH STATEMENT COMMENTS IN EACH POST  -------------------- */?>
                                <a href="index.php?page=profile&id=<?php echo $id;?>">
                                    <div class="eachcommentpicholderright">
                                        <img class="post-pic-thumb" src=<?php echo $profPicUrl;?>></img>
                                    </div>
                                </a>
                                <div class="eachcommentholderleft" style="margin-bottom: 20px">
                                        <form action="" method="post">
                                            <input name="newcomment" type="text" style="width:95%;" placeholder="Add Comment"></input>
                                            <input type="submit" value="Post" class="commentsubmit"></input>
                                            <input readonly="readonly" name="postid" style="display:none;" value="<?php echo $post['_id']->{'$id'};?>">
                                            <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                            <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                        </form>
                                </div>
                            </div><!--ends commentinfo-->
                        </div><!--ends eachpostinside-->
                    </div><!--ends eachpostholder-->
                    <?php
                    $i++;
                }/* -------------------- ENDS FOR EACH STATEMENT POSTS IN ALL POSTS ----------------------- */
                ?><!--ends feeddata-->
