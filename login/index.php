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

<!--         <label>Enter CAPTCHA:</label><br>
        <img src="captcha.php" alt="CAPTCHA"><br>
        <input type="text" name="captcha" required><br><br> -->

        <input type="submit" value="Sign In">
    </form>
</body>
</html>
