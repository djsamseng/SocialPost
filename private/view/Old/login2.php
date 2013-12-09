<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="login2style.css">
        <title>Login</title>
    </head>
    <body>
        <div id="back">
            <div id="top"><h1>SocialPost</h1></div>
            <div id="close">
                <div id="cloud">
                    <div id="loginbox">
                        <h2>Login</h2>
                        <form action="" method="post">
                            <input class="text" type="email" placeholder="Email" name="email" required autofocus><br>
                            <input class="text" type="password" placeholder="Password" name="password"required><br>
                            <?php if (isset($error)) {echo $error.'<br>';}?>
                            <input type="submit" value="Login">
                        </form>
                    </div>
                    <span class='shadow'></span>
                </div>
            </div>
            <div id="footer"><div id="footer-content">
                    <a href="">About SocialPost</a> <a href="">Developers</a> <a href="">Terms & Privacy</a>
            </div></div>

        </div>
        
<?php render('footer');?>
