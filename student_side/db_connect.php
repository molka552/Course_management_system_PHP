<?php
// Database connection
$servername = "localhost"; // Default XAMPP server
$username = "root"; // Default username
$password = ""; // Default password
$dbname = "s&m database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
