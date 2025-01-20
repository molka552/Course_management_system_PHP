<?php
// Include the database connection file
require_once('../db_connection.php');

$message = '';
$course_name = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : '';
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '';
$date = isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '';
$duration = isset($_GET['duration']) ? htmlspecialchars($_GET['duration']) : '';
$course_id = isset($_GET['course_id']) ? htmlspecialchars($_GET['course_id']) : ''; // Get course_id

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = htmlspecialchars($_POST['username']); // Using 'username' instead of 'name'
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']); // Keep phone field
    $address = htmlspecialchars($_POST['address']); // Adjusted to store in students table
    $password = $_POST['password']; // Make sure password is retrieved from form

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Step 1: Insert user details into the users table
        $user_sql = "INSERT INTO users (username, email, password) 
                     VALUES (:username, :email, :password)"; // Include password in users table

        // Prepare and execute the statement
        $user_stmt = $pdo->prepare($user_sql);
        $user_stmt->bindParam(':username', $username);
        $user_stmt->bindParam(':email', $email);
        $user_stmt->bindParam(':password', $hashed_password); // Bind hashed password

        if ($user_stmt->execute()) {
            // Get the last inserted user_id
            $user_id = $pdo->lastInsertId();

            // Step 2: Insert student details into the students table with user_id
            $student_sql = "INSERT INTO students (user_id, phone, student_address) 
                            VALUES (:user_id, :phone, :student_address)"; // Insert phone and address in students table

            // Prepare and execute the statement
            $student_stmt = $pdo->prepare($student_sql);
            $student_stmt->bindParam(':user_id', $user_id);
            $student_stmt->bindParam(':phone', $phone); // Bind phone to the students table
            $student_stmt->bindParam(':student_address', $address); // Bind address to the students table

            if ($student_stmt->execute()) {
                // Step 3: Insert course registration details using student_id and course_id
                $registration_sql = "INSERT INTO registrations (course_id, student_id) 
                                     VALUES (:course_id, :student_id)";

                // Prepare and execute the registration statement
                $registration_stmt = $pdo->prepare($registration_sql);
                $registration_stmt->bindParam(':course_id', $course_id);
                $registration_stmt->bindParam(':student_id', $user_id); // Now using user_id as student_id

                if ($registration_stmt->execute()) {
                    $message = "Registration successful!";
                } else {
                    $message = "Error: Could not register the student.";
                }
            } else {
                $message = "Error: Could not save student details.";
            }
        } else {
            $message = "Error: Could not save user details.";
        }
    } catch (PDOException $e) {
        // Handle any errors
        $message = "Error: " . $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/flex-slider.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/registration.css">
</head>
<body class="body">

<div class="container mt-5">
    <h2>Course Registration Form</h2>
    <?php
    if (!empty($message)) {
        echo "<p class='alert alert-info'>$message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <input type="hidden" class="form-control" id="course_name" name="course_name" value="<?php echo $course_name; ?>" readonly>
        </div>
        <div class="mb-3">
            <input type="hidden" class="form-control" id="category" name="category" value="<?php echo $category; ?>" readonly>
        </div>
        <div class="mb-3">
            <input type="hidden" class="form-control" id="price" name="price" value="<?php echo $price; ?>" readonly>
        </div>
        <div class="mb-3">
            <input type="hidden" class="form-control" id="date" name="date" value="<?php echo $date; ?>" readonly>
        </div>
        <div class="mb-3">
            <input type="hidden" class="form-control" id="duration" name="duration" value="<?php echo $duration; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <button type="submit" class="btn-primary">Register</button>
    </form>
</div>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<div class="back-to-courses">
    <a href="index.php">Back to Courses</a>
</div>

<div class="footer">
    <p>&copy; 2025 S&M Academy. All Rights Reserved.</p>
</div>
</body>
</html>
