            <div class="centerheaderhold">
                <a href="?page=messages&type=newmessage&messageid=<?php echo $messageId;?>">
                    <div class="newmessageicon">
                        +
                    </div>
                </a>
                <div class="centerheaderinside">
                    Messages<br>
                    Conversation With ...
                </div>
            </div>
            <div class="posts">
                <?php
                date_default_timezone_set('EST');
                render("Conversations/messages",array("id"=>$id,"messageData"=>$messageData,"messageId"=>$messageId));
                ?>
            </div>
            <div id="newinputall" class="newinputall">
                <div id="triangleup" class="trianglelinkright"></div>
                <div id="innertriangleup" class="innertrianglelinkright"></div>
                <div class="newinputbody">
                <form action="?page=messages&action=addmessagetoconvo" method="post">
                    <input readonly="readonly" name="messageid" value="<?php echo $messageId;?>" style="display: none;"></input>
                    <div class="textbody">
                        <textarea id="addMessageText" name="addmessagetext" class="newinputtext" cols="30"></textarea>
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
                        <input class="newinputsubmit" type="submit" value="Post"></input>
                    </div>
                </form>
                </div>
            </div>

