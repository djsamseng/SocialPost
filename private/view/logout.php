<?php render("header",array("title"=>"Logout Successful","style"=>"loginstyle.css"));?>
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
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
                <h1><div id="logoutS">Logout Successfull</div></h1>
            </div>
            <div id="mainright">
                <div id="loginbox">
                    <h2>Sign In</h2>
                    <form action="" method="post">
                        <input class="text1" type="email" placeholder="Email" name="email" required autofocus><br>
                        <input class="text2" type="password" placeholder="Password" name="password"required>
                        <input class="text3" type="text" name="zipcode"><br>
                        <?php if (isset($error)) {echo "Incorrect";}?>
                        <input class="login" type="submit" value="Login">
                    </form>
                </div>
            </div>
            <?php render("logintail");?>
        </div>
    </div>    
<?php render('footer');?>
