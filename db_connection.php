<?php
// Database configuration
$host = '127.0.0.1';  // Hostname of your MySQL server
$username = 'root';   // Your MySQL username
$password = '';       // Your MySQL password
$database = 'course_management_system'; // Database name

// Create a new PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // If the connection is successful, this message will not be shown
    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    // If there is an error, this message will be shown
    echo "Connection failed: " . $e->getMessage();
}
?>
