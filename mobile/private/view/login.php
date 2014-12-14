    <?php render("header");?>
        <div data-role="page">
            <div data-role="header">
                <h1>Login</h1>
            </div>
            <div data-role="content" id="login">
                <p>Login Here</p>
                <form id="login" action="" method="post">
                    <label for="loginEmail">Email</label>
                    <input type="email" name="loginEmail" id="loginEmail">
                    <label for="loginPassword">Password</label>
                    <input type="password" name="loginPassword" id="loginPassword">
                    <input type="submit" value="Login">
                </form>
                <?php if (isset($er)) {echo $er;}?>
            </div>
            <div data-role="footer">
                <h4>Footer</h1>
            </div>
        </div>
    <body>
</html>
<script>
$(document).on("pageinit",function() {
    $("#login").submit(function(e) {
        e.stopPropagation();
        e.preventDefault();
        $.post("",{loginEmail:$("#loginEmail").val(),loginPassword:$("#loginPassword").val()},function(data) {
            if (data == "success") {
                window.location.href='';
            } else {
                window.location.href='';
            }
        });
    });
});
</script>
