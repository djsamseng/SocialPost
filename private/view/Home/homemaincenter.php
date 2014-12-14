<?php render("Home/homecentertop", array("feedtype"=>$feedtype,"input"=>$input));?>
<div class="posts">
    <noscript>
        <?php render("Home/homeposts", array("feedtype"=>$feedtype,"input"=>$input,"id"=>$id,"firstpostdate"=>null,"lastpostdate"=>null,"loadbottom"=>true,"numberOfPosts"=>$numberOfPosts));?>
    </noscript>
</div>
<form onsubmit="morePosts(); return false;" action=?page=home&action=getmoreposts&feedtype=<?php echo $feedtype;?>&inputstate=<?php echo $input;?> method="post" id="moreposts">
    <input id="currentnumberofposts" readonly="readonly" name="currentnumberofposts" style="display:none" value="<?php echo count($feeddata);?>">
    <input id="morefeedtype" readonly="readonly" style="display:none" value="<?php echo $feedtype;?>">
    <input type="submit" value="More">
</form>
<br><br>

