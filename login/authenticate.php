<?php
session_start();

// CAPTCHA verification
require_once('/recaptcha-php-1.10/recaptchalib.php');
$privatekey = "6LccMCMrAAAAAH0vb8WGiFPZVQ9LZ6xnG_gbw9gi"; // Replace with your actual private key
$resp = recaptcha_check_answer(
    $privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]
);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die("The reCAPTCHA wasn't entered correctly. Go back and try it again. " .
        "(reCAPTCHA said: " . $resp->error . ")");
}

// Database connection
$host = 'localhost';
$db   = 'users';
$user = 'root';
$pass = 'COSC4343';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed.");
}

// Hash the password using MD5
$username = $_POST['username'];
$password = md5($_POST['password']);

// Check credentials
$stmt = $pdo->prepare("SELECT * FROM UserAccounts WHERE username = ? AND password = ?");
$stmt->execute([$username, $password]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['username'] = $username;
    $_SESSION['clearance'] = $user['clearance'];
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid credentials. <a href='index.php'>Try again</a>";
}
?>