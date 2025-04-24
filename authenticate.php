<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// CAPTCHA verification
$secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
$responseKey = $_POST['g-recaptcha-response'];
$userIP = $_SERVER['REMOTE_ADDR'];

// Verify the CAPTCHA response with Google's API
$verifyURL = "https://www.google.com/recaptcha/api/siteverify";
$response = file_get_contents($verifyURL . "?secret=" . $secretKey . "&response=" . $responseKey . "&remoteip=" . $userIP);
$responseData = json_decode($response);

if (!$responseData->success) {
    die("The reCAPTCHA wasn't entered correctly. Go back and try again.");
}

// Database credentials
$host = 'localhost';
$db   = 'users';
$user = 'root';
$pass = $_ENV['DB_PASSWORD']; // Load from .env
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

// Hash entered password
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