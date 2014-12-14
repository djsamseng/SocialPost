<?php render("header",array("title"=>"Login","style"=>"loginstyle.css"));?>
<?php render("banner");?>
    <div id="back">
        <div id="cloudhold">
        <div id="cloud">
        </div>
        </div>

        <div id="close">
            <div id="mainleft">
                <div id="clouda"></div>
                            </div>
            <div id="maincenter">
                <br><br><br><br><br><br><br><br><br><br><br>
                <h1>SocialPost</h1>
                <div id="outsidepost">
                <div id="postholder">
                    <div id="posts">
                        <?php if (isset($posts)&& $posts != null){
                            foreach ($posts as $post) {
                                ?> <div id="eachpostcontainer"><div id="eachpost">
                                <?php echo $post["text"];?>
                                </div></div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <div id="postform">
                        <form>
                            <input type="text" class="postforminput" placeholder="Post Here">
                            <input type="submit" class="postformsubmit" value="Post">
                        </form>
                    </div>
                </div>
                </div>
            </div>
            <div id="mainright">
                <div id="loginbox">
                    <h2>Sign In <?php// echo htmlspecialchars($_GET["page"])=="create";?></h2>
                    <form action="" method="post">
                        <input class="text1" type="email" placeholder="Email" name="email" required autofocus><br>
                        <input class="text2" type="password" placeholder="Password" name="password"required>
                        <input class="text3" type="text" name="zipcode"><br>
                        <?php if (isset($_GET["er"])&&htmlspecialchars($_GET["er"])=="invalid") {echo "Invalid";}?>
                        <input class="login" type="submit" value="Login">
                    </form>
                </div>
                <div id="createbox">
                    <h3>Create An Account</h3>
                    <form action="?page=create" method="post">
                        <input class="text1" type="text" placeholder="First Name" name="nfirstname"required><br>
                        <input class="text1" type="text" placeholder="Last Name" name="nlastname"required><br>
                        <input class="text1" type="email" placeholder="Email" name="nemail" required><br>
                        <input class="text2" type="password" placeholder="Password" name="npassword">
                        <input class="text3" type="text" name="zipcode"><br>
                        <input class="sign" type="submit" value="Sign Up">
                        <?php if (isset($_GET["er"])&& htmlspecialchars($_GET["er"])=="emailtaken") {echo "Email taken";}?>
                    </form>
                </div>
            </div>
            <?php render("logintail");?>
        </div>
    </div>
<?php render('footer');?>
