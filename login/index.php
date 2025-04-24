<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="authenticate.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <!-- CAPTCHA Integration -->
        <?php
          require_once('recaptchalib.php');
          $publickey = "6LccMCMrAAAAAMzo1mC9zvQfgmm6AOhiaO1Pfo8p"; // Replace with your actual public key
          echo recaptcha_get_html($publickey);
        ?>
        <br><br>
        
        <input type="submit" value="Sign In">
    </form>
</body>
</html>