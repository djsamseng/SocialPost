<?php if ($searchResults != null) {
                    foreach ($searchResults as $result) {
                    ?>
                        <div class="searchresult">
                            <a onclick="link(this); return false;" class="searchnamelink" href="index.php?page=profile&id=<?php echo $result['_id']->{'$id'};?>">
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
                            <a onclick="link(this); return false;" class="searchnamelink" href="index.php?page=profile&id=<?php echo $result['_id']->{'$id'};?>">
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
