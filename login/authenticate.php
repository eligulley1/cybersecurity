<?php
session_start();

// CAPTCHA check
// if ($_POST["captcha"] !== $_SESSION["captcha"]) {
//     die("CAPTCHA failed. <a href='index.php'>Try again</a>");
// }

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
    echo "Welcome, " . htmlspecialchars($username) . "!";
} else {
    echo "Invalid credentials. <a href='index.php'>Try again</a>";
}
?>
