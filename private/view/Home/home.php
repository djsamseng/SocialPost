<script>
var id="<?php echo $_SESSION["id"];//need to encode / decode?>";
var page="home";
</script>
<?php render("header", array("title"=>"Home","style"=>"Home/newhomestyle.css","javascript"=>array("../private/view/Home/homejs.js")));
?>
<div id="back">
    <?php render("bannerIn", array("name"=>$_SESSION['firstname']." ".$_SESSION['lastname']));?>
    <div id="close">
        <div id="mainleft">
            <?php render("Home/homemainleft",array("feedtype"=>$feedtype,"input"=>$input));?>
            </div>
        <div id="maincenter">
            <?php render("Home/homemaincenter",array("feedtype"=>$feedtype,"input"=>$input,"id"=>$id,"numberOfPosts"=>$numberOfPosts));?>
        </div>
        <div class="clear">
        </div>
    </div><!--ends close-->
    <div id="chatholder" class="<?php if (isset($_SESSION["chattoggle"]) && !($_SESSION["chattoggle"])) {echo 'chatholderhidden';}else{echo 'chatholder';}?>">
        <a id="chatheaderhold" href="index.php?page=home&action=chattoggle&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
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
            <a id="bottomchattoggle" href="index.php?page=home&action=chattoggle&inputstate=<?php echo $input;?>&feedtype=<?php echo $feedtype;?>">
                <div class="outsidetoolbar">
                Messages
                </div>
            </a>
        </div>
    </div>
<div><!--ends back-->
<?php render("footer");?>

