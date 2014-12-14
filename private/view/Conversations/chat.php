    <div id="chatholder" class="<?php if (isset($_SESSION["chattoggle"]) && !($_SESSION["chattoggle"])) {echo 'chatholderhidden';}else{echo 'chatholder';}?>">
        <a id="chatheaderhold" href="index.php?page=home&action=chattoggle&messageid=<?php echo $messageid;?>">
            <div class="chatheader">
                Messages
            </div>
        </a>
        <div class="chatsearch">
            <form>
                <input type="text" placeholder="Search" style="width: 90%;">
                <input type="submit" style="display: none">
            </form>
        </div>
        <div class="chatbox">
        HERE
        </div>
    </div>
        <div class="bottomposition">
        <div class="bottomholder">
            <a id="bottomchattoggle" href="index.php?page=home&action=chattoggle&messageid=<?php echo $messageid;?>">
                <div class="outsidetoolbar">
                Messages
                </div>
            </a>
        </div>
    </div>


