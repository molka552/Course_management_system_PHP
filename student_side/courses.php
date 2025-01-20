<?php
// Include database connection
include 'db_connect.php';

// Fetch courses from the database
$sql = "SELECT id, category, name, date, duration, price, image FROM courses";
$result = $conn->query($sql);
?>
