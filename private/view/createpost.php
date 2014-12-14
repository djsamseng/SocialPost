<div class="bottomposition2">
<div class="bottomholder2">
    <div class="outsidetoolbar2">
    <div class="toolbarholder2">
        <div class="insidetoolbar2">
        <div class="postform2">
            <form action="index.php?page=home&action=newpost&bottom=<?php echo $bottomtype;?>&feedtype=<?php echo $feedtype;?>" method="post">
                <textarea name="newpost" cols="10" class="postforminput2" placeholder="Post Here"></textarea>
                <input type="submit" class="postformsubmit2" value="Post">
                <select class="postformselect2" name="postformselect">
                    <option value="friends"<?php if ($feedtype=="friends"){echo 'selected="selected"';}?>>Friends</option>
                    <option value="nearme" <?php if ($feedtype=="nearme"){echo 'selected="selected"';}?>>Near Me</option>
                    <option value="world" <?php if ($feedtype=="world"){echo 'selected="selected"';}?>>World</option>
                </select>
            </form>
        </div>
        </div>
    </div>
    </div>
    <div class="outsidetoolbar">
    <div class="toolbarholder">
        <div class="postform">
            <a href="index.php?page=home&feedtype=<?php echo $feedtype;?>"><button type="button" class="topostbutton">Click to Post</button></a>
        </div>
        </div>
    </div>
    </div>
</div>
</div>
