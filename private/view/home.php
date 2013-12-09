<?php render("header", array("title"=>"Home","style"=>"homestyle.css"));
?>
<div id="back">
    <?php render("bannerIn", array("name"=>$_SESSION['firstname']." ".$_SESSION['lastname']));?>
    <div id="close">
        <div id="mainleft">
            Left<br>
        </div>
        <div id="maincenter">
            <h2>Home</h2>
        </div>
        <div id="mainright">
            Right
        </div>
    </div>
<div>
<?php render("footer")?>
