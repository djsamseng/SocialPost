<div class="centerheaderhold">
        <div class="centerheaderinside">
            <div class="centerfeedselecthold">   
                <a id="friendsfeedlink" href="index.php?page=home&feedtype=friends">
                <div class="centerfeedselect" style="<?php if ($feedtype=="friends"){echo 'background: #FFFFFF';}?>">
                Friends
                </div>
                </a>
                <a id="nearmefeedlink" href="index.php?page=home&feedtype=nearme">
                <div class="centerfeedselect" style="<?php if ($feedtype=="nearme"){echo 'background: #FFFFFF';}?>">
                Near Me
                </div>
                </a>
                <a id="worldfeedlink" style="" href="index.php?page=home&feedtype=world">
                <div class="centerfeedselect" style="<?php if ($feedtype=="world"){echo 'background: #FFFFFF';}?>">
                World
                </div>
                </a>
                <a id="otherfeedlink" style="" href="#">
                <div class="centerfeedselect" style="<?php if ($feedtype==""){echo 'background: #FFFFFF';}?>">
                Other
                </div>
                </a>
                <div class="clear">
                </div>
            </div>
            <div class="newpostselectholder">
                <a id="newtext" href="index.php?page=home&input=text&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                    <div class="newpostselect">
                        <div class="newposticonholder">
                        </div>
                        Text
                    </div>
                </a>
                <a id="newphoto" href="index.php?page=home&input=photo&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                    <div class="newpostselect">
                        <div class="newposticonholder">
                        </div>
                        Photo
                    </div>
                </a>
                <a id="newvideo" href="index.php?page=home&input=video&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                    <div class="newpostselect">
                        <div class="newposticonholder">
                        </div>
                        Video
                    </div>
                </a>
                <a id="newlocation" href="index.php?page=home&input=location&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                    <div class="newpostselect">
                        <div class="newposticonholder">
                        </div>
                        Location
                    </div>
                </a>
                <a id="newlink" href="index.php?page=home&input=link&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                    <div class="newpostselect">
                        <div class="newposticonholder">
                        </div>
                        Link
                    </div>
                </a>

                <div class="clear">
                </div>
            </div>
            <div id="newinputall" class="<?php if ($input != 'text' && $input != 'photo' && $input != 'video' && $input != 'location' && $input != 'link') {echo 'newinputallnone';}else{echo 'newinputall';}?>">
                <div id="triangleup" class="triangle<?php echo $input;?>"></div>
                <div id="innertriangleup" class="innertriangle<?php echo $input;?>"></div>
                <div class="newinputbody">
                <form onSubmit="return newPost(this);" action="?page=home&action=newpost&feedtype=<?php echo $feedtype;?>&inputstate=<?php echo $input;?>" method="post">
                    <input readonly="readonly" value="<?php echo $input?>" style="display: none;"></input>
                    <div class="textbody">
                        <textarea id="newInputText" name="newinputtext" class="newinputtext" cols="30"></textarea>
                    </div>
                    <div class="undertextbody">
                        Expires In
                        <select id="expireTime" name="expireTime">
                            <option name="fivemin">5 Minutes</option>
                            <option name="twohours">2 Hours</option>
                            <option name="oneday">1 Day</option>
                            <option name="thirtydays">30 Days</option>
                            <option name="oneyear">1 Year</option>
                            <option name="never" selected="selected">Never</option>
                        </select>
                        Visibility
                        <select id="postTo" name="postTo">
                            <option name="friends" selected="selected">Friends</option>
                            <option name="nearme">Near Me</option>
                            <option name="world">World</option>
                        </select>
                        <span id="addlocationholder">
                            <button type="button" id="addlocation" onclick="return addLocation()";>Add Location</button>
                        </span>
                        <input class="newinputsubmit" type="submit" value="Post"></input>
                    </div>
                </form>
                </div>
            </div>
            </div>
            </div>

