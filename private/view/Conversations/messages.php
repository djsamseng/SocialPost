            <?php
                /*require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/homefunctions.php');
                if (!($loadBottom)) {
                    $loadBottom = false;
                }
                if (!(isset($newLoad))) {
                    $newLoad = true;
                }
                extract(getHome($id,$firstpostdate,$lastpostdate,$feedtype,$loadBottom,$newLoad,$numberOfPosts,$myLat,$myLng));*/
                $i = 0;
                date_default_timezone_set('EST');
                foreach ($messageData as $post) {
                    ?>
                    <span class="postdatesec" style="display:none"><?php echo $post['messages']["date"]->sec;?></span>
                    <div class="eachpostholder">
                        <div class="eachpostinside">
                            <?php if ($post['messages']['userId']->{'$id'} == $id) { /* ------- IF FROM HERE --------- */?>
                            <div class="postleftholderright">
                                <a class="postbynametext" href="profile.php?id=<?php echo $post['messages']['userId']->{'$id'};?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['messages']['profPicUrl'];?>></img>
                                    </div>
                                    <span class="postbyname"><?php echo $post['messages']['firstname']." ".$post['messages']['lastname'];?></span>
                                </a>
                            </div>
                            <div class="postbodyleft">
                            <?php } else { /* --------- TO HERE ELSE ---------- */?>
                            <div class="postleftholder">
                                <a class="postbynametext" href="profile.php?id=<?php echo $post['messages']['userId']->{'$id'};?>">
                                    <div class="post-pic-thumb-holder">
                                        <img class="post-pic-thumb" src=<?php echo $post['messages']['profPicUrl'];?>></img>
                                    </div>
                                    <span class="postbyname"><?php echo $post['messages']['firstname']." ".$post['messages']['lastname'];?></span>
                                </a>
                            </div>
                            <div class="postbody">
                            <?php } /* ----------- ENDS IF ELSE STATEMENT ---------- */?>
                                <div class="eachpost"><?php
                                    echo $post['messages']["text"];
                                    ?>
                                </div>
                                <?php if ($post['messages']['userId']->{'$id'} == $id) { /* ------- IF FROM HERE --------- */?>
                                <div class="optionsholder">
                                    <div class="optionslistholder">
                                        <div class="postoption">
                                            <form>
                                                <input type="submit" value="Edit" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                            </form>
                                        </div>
                                        <div class="postoption">
                                            <form>
                                                <input type="submit" value="Delete" style="border: 0; width: 100%; height 100%; border-radius: 0; margin: 0; background: #F0F0F0;">
                                                <input readonly="readonly" name="postid" style="display:none" value="<?php echo $post['_id']->{'$id'};?>">
                                                <input readonly="readonly" name="postersid" style="display:none" value="<?php echo $post['userId'];?>">
                                                <input readonly="readonly" name="collection" style="display:none" value="<?php echo $post['collection'];?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php } /* --------- ENDS IF STATEMENT ---------- */?>
                                <div class="postbottomholder">
                                    <div class="postdateholder">
                                        <div class="postdate"><?php
                                            echo date('M d h:i a',$post['messages']["date"]->sec);
                                            ?>
                                        </div>
                                        <div class="expiredate">
                                            Expires<br>
                                            <?php echo date('M d, Y h:i a',$post['messages']["expiration"]->sec);?>
                                        </div>
                                    </div>
                                    <div class="postlocationholder">
                                        <?php if (isset($post['messaages']["near"]) && strlen($post['messages']["near"]) > 0) {?>
                                        <div class="locationicon">
                                            Near <?php echo $post['messages']["near"];?>
                                        </div>
                                        <div class="locationholder">
                                        <div class="locationinfo">
                                            Please enable JavaScript to use this feature
                                            <?php //render("mapItWindow",array("num"=>count($feeddata),"iteration"=>$i));?>
                                        </div>
                                        </div>
                                        <?php }?>
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
                
