<?php
// Include database connection file
include('../../db_connection.php');

// Initialize a variable to track if the insert was successful
$insertSuccess = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = htmlspecialchars($_POST['name']);
    $date = htmlspecialchars($_POST['date']);
    $duration = htmlspecialchars($_POST['duration']);
    $price = htmlspecialchars($_POST['price']);
    $category = htmlspecialchars($_POST['category']);

    // Convert the date from dd/mm/yyyy to yyyy-mm-dd format
    $dateParts = explode('/', $date);
    $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
    $date = $formattedDate;

    // Handle file upload
    $imagePath = '';
    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] == 0) {
        $filename = $_FILES['fileUpload']['name'];
        $tmp_name = $_FILES['fileUpload']['tmp_name'];
        $fileSize = $_FILES['fileUpload']['size'];
        $fileType = $_FILES['fileUpload']['type'];

        // File validation: Allow only image files and limit the size
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB max

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $destination = "uploads/" . basename($filename); // Upload directory
            if (move_uploaded_file($tmp_name, $destination)) {
                $imagePath = $destination;
            } else {
                echo "File upload failed.";
                exit;
            }
        } else {
            echo "Invalid file type or file size exceeds the limit.";
            exit;
        }
    }

    // Prepared statement to prevent SQL injection
    try {
        if ($imagePath) {
            $sql = "INSERT INTO courses (name, date, duration, price, category, image) VALUES (:name, :date, :duration, :price, :category, :image)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':image', $imagePath);
        } else {
            $sql = "INSERT INTO courses (name, date, duration, price, category) VALUES (:name, :date, :duration, :price, :category)";
            $stmt = $pdo->prepare($sql);
        }

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);

        // Execute the prepared statement
        $stmt->execute();
        $insertSuccess = true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
