<?php render("header", array("title"=>"Home","style"=>"Home/newhomestyle.css"));
?>
<div id="back">
    <?php render("bannerIn", array("name"=>$_SESSION['firstname']." ".$_SESSION['lastname']));?>
    <div id="close">
        <div id="mainleft">
            Left<br>
        </div>
        <div id="maincenter">
            <h2>Search</h2>
            <div class="newsearchbox">
                <form action="index.php" method="get">
                    <input class="search-input" type="text" name="search" placeholder="Search">
                    <input class="search-submit" type="submit">
                    <input style="visibility: hidden; height: 0; width:0;" type="text" name="page" value="search">
            </div>
            <div class="searchresultbox">
                <?php if ($searchresults != null) {
                    foreach ($searchresults as $result) {
                    ?>
                        <div class="searchresult">
                            <a class="searchnamelink" href="profile.php?id=<?php echo $result['_id']->{'$id'};?>">
                                <div class="search-pic-thumb-holder">
                                    <img class="search-pic-thumb" src="<?php echo $result['profPicUrl'];?>"></img>
                                </div>
                                <span class="searchresultname">
                                    <?php echo $result["firstname"]." ".$result["lastname"];
                                    ?>
                                </span>
                            </a>
                        </div>
                        <div class="searchresult">
                            <a class="searchnamelink" href="profile.php?id=<?php echo $result['_id']->{'$id'};?>">
                                <div class="search-pic-thumb-holder">
                                    <img class="search-pic-thumb" src="<?php echo $result['profPicUrl'];?>"></img>
                                </div>
                                <span class="searchresultname">
                                    <?php echo $result["firstname"]." ".$result["lastname"];
                                    ?>
                                </span>
                            </a>
                        </div>
                    <?php
                }
            }?>
                </div>
            </div>
        </div>
        <div id="mainright">
            <div class="requests">
                Requests<br>
                Friend Requests<br>
                <?php
                foreach ($requests["friendRequests"] as $friendRequest) {
                    ?> <a href="profile.php?id=<?php echo $friendRequest["userId"];?>">
                    <?php echo $friendRequest["firstname"]." ".$friendRequest["lastname"];?></a><br>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<div>
<?php render("footer")?>
