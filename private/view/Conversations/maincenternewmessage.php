            <div class="centerheaderhold">
                <div class="centerheaderinside">
                    Messages<br>
                    Conversation With ...
                </div>
            </div>
            <div class="newmessageinfoall">
                <form action="?page=messages&type=newmessage&action=searchfriends&messageid=<?php echo $messageId;?>" method="post">
                    <input type="text" name="messagefriendsearch" placeholder="Search Friends"></input>
                    <input type="submit" value="Search"></input>
                </form>
                <div id="messagefriends">
                    <?php 
                    foreach ($actionData as $result) {?>
                        <div class="mfriendsearchresult">
                            <div class="meachfriendpicholder">
                                <img class="search-pic-thumb" src="<?php echo $result['profPicUrl']?>"></img>
                            </div>
                            <span class="msearchname">
                                <?php echo $result['firstname']." ".$result['lastname'];?>
                            </span>
                            <form action="?page=messages&action=addtomessage" method="post">
                                <input readonly="readonly" name="messageid" value="<?php echo $messageId;?>" style="display:none"></input>
                                <input readonly="readonly" name="addtomessageid" value="<?php echo $result['_id']->{'$id'};?>" style="display:none"></input>
                                <input type="submit" value="Add">
                            </form>
                        </div>
                    <?php }?>
                    <div class="clear">
                    </div>
                </div>
            </div>
            <div id="newinputall" class="newinputall">
                <div id="triangleup" class="trianglelinkright"></div>
                <div id="innertriangleup" class="innertrianglelinkright"></div>
                <div class="newinputbody">
                <form  action="index.php?page=messages&action=addtomessage" method="post">
                    <input readonly="readonly" name="messageid" value="<?php echo $messageId;?>" style="display:none"></input>
                    <input readonly="readonly" name="addtomessageid" value="<?php echo $id;?>" style="display:none"></input>
                    <div class="textbody">
                        <textarea id="newInputText" name="newinputtext" class="newinputtext" cols="30"></textarea>
                    </div>
                    <div class="undertextbody">
                        Expires In
                        <select id="expireTime" name="expireTime">
                            <option name="fivemin">5 Minutes</option>
                            <option name="onehour">2 Hours</option>
                            <option name="oneday">1 Day</option>
                            <option name="thirtydays">30 Days</option>
                            <option name="oneyear">1 Year</option>
                            <option name="never" selected="selected">Never</option>
                        </select>
                        <span id="addlocationholder">
                            <button type="button" id="addlocation">Add Location</button>
                        </span>
                        <input class="newinputsubmit" type="submit" value="Post"></input>
                    </div>
                </form>
                </div>
            </div>

