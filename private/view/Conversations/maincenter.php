            <div class="centerheaderhold">
                <a href="?page=messages&type=newmessage">
                    <div class="newmessageicon">
                        +
                    </div>
                </a>
                <div class="centerheaderinside">
                    Conversations
                </div>
            </div>
            <div class="posts">
                <?php
                foreach ($allMessages as $message) {?>
                    <a href="index.php?page=messages&type=message&messageid=<?php echo $message['_id']->{'$id'};?>">
                    <div class="maineachholder">
                        <div class="maineachnames">
                            <?php foreach ($message['users'] as $user) {
                                echo $user['firstname']." ".$user['lastname'];
                            }?>
                        </div>
                        <div class="maineachpic">
                            <img class="post-pic-thumb" src="<?php echo $message['messages'][count($message['messages'])-1]['text'];?>"></img>
                        </div>
                        <div class="maineachtext">
                            <?php echo $message['messages'][count($message['messages'])-1]['text'];?>
                        </div>
                    </div>
                    </a>
                <?php }?>
            </div> 
