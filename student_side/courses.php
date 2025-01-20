<?php
// Include database connection
require_once('../db_connection.php');

// Fetch courses from the database
$sql = "SELECT * FROM courses";
$result = $pdo->query($sql);
?>
