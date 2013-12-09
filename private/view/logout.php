<?php render("header",array("title"=>"Logout Successful","style"=>"login4style.css"));?>
<?php render("banner");?>
    <div id="back">

        <div id="close">
            <div id="mainleft">
                <div id="clouda"></div>
                            </div>
            <div id="maincenter">
                <div id="cloud">
                    <h1><div id="logoutS">Logout Successfull</div></h1>
                </div>
            </div>
            <div id="mainright">
                <div id="loginbox">
                    <h2>Sign In</h2>
                    <form action="" method="post">
                        <input class="text" type="email" placeholder="Email" name="email" required autofocus><br>
                        <input class="text" type="password" placeholder="Password" name="password"required><br>
                        <?php if (isset($error)) {echo "Incorrect";}?>
                        <input class="login" type="submit" value="Login">
                    </form>
                </div>
            </div>
            <?php render("logintail");?>
        </div>
    </div>    
<?php render('footer');?>
