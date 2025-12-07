<?php
// db.php - Database connection file

$host     = "localhost";   // Database host
$username = "root";        // Database username (default in XAMPP/WAMP is 'root')
$password = "";            // Database password (default is empty in XAMPP/WAMP)
$database = "nidra_homes"; // Your database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Optional: set character set to UTF-8
mysqli_set_charset($conn, "utf8mb4");
?>
