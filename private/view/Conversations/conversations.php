<script>
var page="messages";
</script>
<?php render("header", array("title"=>"Home","style"=>"Home/newhomestyle.css","javascript"=>array("../private/view/Home/homejs.js")));
?>
<div id="back">
    <?php render("bannerIn", array("name"=>$_SESSION['firstname']." ".$_SESSION['lastname']));?>
    <div id="close">
        <div id="mainleft">
            <?php render("Conversations/mainleft",array("id"=>$id,"allMessages"=>$allMessages,"profpicurl"=>$profpicurl));?>
                    </div>
        <div id="maincenter">
            <?php 
                if ($type == "newmessage") {
                    render("Conversations/maincenternewmessage",array("id"=>$id,"actionData"=>$actionData,"messageId"=>$messageId,"allMessages"=>$allMessages));
                } else if ($type == "message") {
                    render("Conversations/maincentermessage",array("id"=>$id,"messageId"=>$messageId,"allMessages"=>$allMessages,"messageData"=>$messageData));
                } else {
                    render("Conversations/maincenter",array("id"=>$id,"allMessages"=>$allMessages));
                }
            ?>
        </div>
        <div class="clear">
        </div>
    </div>
    <?php render("Conversations/chat",array("messageid"=>$messageId));?>
</div>
<?php render("footer");?>

