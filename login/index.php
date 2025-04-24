<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="authenticate.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <!-- CAPTCHA Integration -->
        <!-- CAPTCHA Integration -->
        <div class="g-recaptcha" data-sitekey="6LccMCMrAAAAAMzo1mC9zvQfgmm6AOhiaO1Pfo8p"></div>
        <br><br>
        
        <input type="submit" value="Sign In">
    </form>
</body>
</html>