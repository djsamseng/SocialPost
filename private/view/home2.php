<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once('../controller/includes/helper.php');
render("header",array("title"=>"Login","style"=>"login4style.css"));?>
<?php render("banner");?>
    <div id="back">
        <div id="cloud"></div>

        <div id="close">
            <div id="mainleft">
                <div id="clouda"></div>
                            </div>
            <div id="maincenter">
                                <h1>SocialPost</h1>
            </div>
            <div id="mainright">
                <div id="loginbox">
                    <h2>Sign In <?php// echo htmlspecialchars($_GET["page"])=="create";?></h2>
                    <form action="" method="post">
                        <input class="text" type="email" placeholder="Email" name="email" required autofocus><br>
                        <input class="text" type="password" placeholder="Password" name="password"required><br>
                        <?php if (isset($error)) {echo "Incorrect";}?>
                        <input class="login" type="submit" value="Login">
                    </form>
                </div>
                <div id="createbox">
                    <h3>Create An Account</h3>
                    <form action="?page=create" method="post">
                        <input class="text" type="text" placeholder="First Name" name="nfirstname"required><br>
                        <input class="text" type="text" placeholder="Last Name" name="nlastname"required><br>
                        <input class="text" type="email" placeholder="Email" name="nemail" required><br>
                        <input class="text" type="password" placeholder="Password" name="npassword"required><br>
                        <input class="sign" type="submit" value="Sign Up">
                        <?php if (isset($_GET["er"])&& htmlspecialchars($_GET["er"])=="emailtaken") {echo "Email taken";}?>
                    </form>
                </div>
            </div>
            <?php render("logintail");?>
        </div>
    </div>    
<?php render('footer');?>
