    <?php render("header");?>
        <div data-role="page" id="onePost">
            <div data-role="header">
                <h1>Modify</h1>
            </div>
            <div data-role="content">
            <?php
            $i = 0;
            $post = $post[0];
            date_default_timezone_set('EST');
                    ?>
                    <span class="postdatesec" style="display:none"><?php echo $post["date"]->sec;?></span>
                    <div class="eachpostholder">
                        <div class="eachpostinside">
                            <?php if ($post['userId'] == $id) { /* ------- IF FROM HERE --------- */?>
                            <div class="postleftholderright">
                                <a class="postbynametext" href="profile.php?id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder-right">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?>
                                    </div>
                                </a>
                                <form onsubmit="removePost(this); return false;" method="post" data-role="none">
                                    <input readonly="readonly" style="display:none;" data-role="none" name="postId" value="<?php echo $post['_id']->{'$id'};?>">
                                    <input readonly="readonly" style="display:none;" data-role="none" name="collection" value="<?php echo $post['collection'];?>">
                                    <input type="submit" name="submit" data-role="none" value="Remove">
                                </form>
                                <div class="clear">
                                </div>
                            </div>
                            <div class="postbodyleft">
                            <?php } else { /* --------- TO HERE ELSE ---------- */?>
                            <div class="postleftholder">
                                <a class="postbynametext" href="profile.php?id=<?php echo $post['userId'];?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['profPicUrl'];?>></img>
                                    </div>
                                    <div class="postbyname"><?php echo $post['firstname']." ".$post['lastname'];?>
                                    </div>
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
                                <?php if ($post['userId'] == $id) { /* ------- IF FROM HERE --------- */?>
                                                                <?php } /* --------- ENDS IF STATEMENT ---------- */?>
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
                                    <div onsubmit="return false;" class="commentactionholder">
                                        <form name="likeaction" method="post">
                                            <input type="submit" value="Like" name="like">
                                            <input type="submit" value="Dislike" name="dislike">
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
                                <div class="commentinfo">
                                    <?php 
                                        if ($post["likeCount"] == 1){
                                            echo '1 person likes this';

                                        } else if ($post["likeCount"] > 1) {
                                            echo $post["likeCount"]." like this";
                                        }
                                        if ($post["likeCount"] > 0 && $post["dislikeCount"] > 0) {
                                            echo ", ";
                                        }
                                        if ($post["dislikeCount"] == 1) {
                                            echo "1 person dislikes this";
                                        } else if ($post["dislikeCount"] > 1) {
                                            echo $post["dislikeCount"]." dislike this";
                                        }
                                        if ($post["likeCount"] == 0 && $post["dislikeCount"] == 0) {
                                            echo "Be the first to like or dislike this";
                                        }
                                    ?>
                                </div>
                                <?php foreach ($post["comments"] as $comment) { /* ------------ FOR EACH STATEMENT ------------- */
                                    if ($comment['userId'] == $id) { /* ---------- IF STATEMENT FROM HERE ------------- */?>
                                        <a href="profile.php?id=<?php echo $comment['userId'];?>">
                                            <div class="eachcommentpicholderright">
                                                <img class="commentpic" src="<?php echo $comment['profPicUrl'];?>">
                                            </div>
                                        </a>
                                        <div class="eachcommentholderleft">
                                            <div class="eachcommenttextleft">
                                            <a style="color: #3399FF;" href="profile.php?id=<?php echo $comment['userId'];?>">
                                            <?php echo $comment["firstname"]." ".$comment["lastname"]?>
                                            </a>
                                        <?php
                                            echo " - ".$comment["text"];?>
                                            </div>
                                            <div class="eachcommentlikeleft">
                                                <?php echo $comment["date"];?><br>
                                                <form onsubmit="return false;" name="likeaction" method="post">
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
                                                        <form onsubmit="return false;" method="post">
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
                                                <a href="profile.php?id=<?php echo $comment['userId'];?>">
                                                    <div class="eachcommentpicholder">
                                                        <img class="commentpic" src="<?php echo $comment['profPicUrl'];?>">
                                                    </div>
                                                </a>
                                                <div class="eachcommentholder">
                                                    <div class="eachcommenttext">
                                                        <a style="color: #3399FF;" href="profile.php?id=<?php echo $comment['userId'];?>">
                                                            <?php echo $comment["firstname"]." ".$comment["lastname"]?>
                                                        </a>
                                                        <?php
                                                            echo " - ".$comment["text"];?>
                                                    </div>
                                                    <div class="eachcommentlike">
                                                        <?php echo $comment["date"];?><br>
                                                        <form onsubmit="return false;" name="likeaction" method="post">
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
                                <a href="profile.php?id=<?php echo $id;?>">
                                    <div class="eachcommentpicholderright">
                                        <img class="post-pic-thumb" src=<?php echo $profPicUrl;?>></img>
                                    </div>
                                </a>
                                <div class="eachcommentholderleft" style="margin-bottom: 20px">
                                    <div class="eachcommenttextleft">
                                        <form onsubmit="return false;" method="post">
                                            <input name="newcomment" type="text" style="width:80%;" placeholder="Add Comment"></input>
                                            <input type="submit" value="Post" class="commentsubmit"></input>
                                            <input readonly="readonly" name="postid" style="display:none;" value="<?php echo $post['_id']->{'$id'};?>">
                                            <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                            <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                        </form>
                                    </div>
                                </div>
                            </div><!--ends commentinfo-->
                        </div><!--ends eachpostinside-->
                    </div><!--ends eachpostholder-->
                    <?php
                    $i++;
                /* -------------------- ENDS FOR EACH STATEMENT POSTS IN ALL POSTS ----------------------- */
                ?><!--ends feeddata-->
            </div>
                
