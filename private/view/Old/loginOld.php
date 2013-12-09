<?php render("header", array("title"=>"Login"));?>
<h1>SocialPost</h1>
<h2>Login</h2>
<br>
<form action="" method="post">
Email: <input type="email" name="email"required><br>
Password: <input type="password" name="password"required><br>
<?php if (isset($error)) {echo $error.'<br>';}?>
<input type="submit" value="Login">
</form>
<?php render('footer');?>
