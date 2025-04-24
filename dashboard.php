<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['clearance'])) {
    die("Access denied. <a href='index.php'>Login again</a>");
}

$clearance = $_SESSION['clearance'];
echo "<h2>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h2>";
echo "<p>Your clearance level: " . htmlspecialchars($clearance) . "</p>";

echo "<h3>Classified Images:</h3>";
echo "<div>";

if ($clearance === 'T') {
    echo "<img src='images/TopSecret.png' alt='Secret' style='width:200px;'><br>";
    echo "<img src='images/Secret.png' alt='Secret' style='width:200px;'><br>";
    echo "<img src='images/Confidential.png' alt='Confidential' style='width:200px;'><br>";
    echo "<img src='images/Unclassified.png' alt='Unclassified' style='width:200px;'><br>";
} elseif ($clearance === 'S') {
    echo "<img src='images/Secret.png' alt='Confidential' style='width:200px;'><br>";
    echo "<img src='images/Confidential.png' alt='Confidential' style='width:200px;'><br>";
    echo "<img src='images/Unclassified.png' alt='Unclassified' style='width:200px;'><br>";
} elseif ($clearance === 'C') {
    echo "<img src='images/Confidential.png' alt='Confidential' style='width:200px;'><br>";
    echo "<img src='images/Unclassified.png' alt='Unclassified' style='width:200px;'><br>";
} elseif ($clearance === 'U') {
    echo "<img src='images/Unclassified.png' alt='Unclassified' style='width:200px;'><br>";
} else {
    echo "Unknown clearance level.";
}

echo "</div>";

echo "<form method='POST' action='index.php' style='margin-top:20px;'>
        <button type='submit'>Logout</button>
      </form>";

?>
