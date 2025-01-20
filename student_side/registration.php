<?php
// Include the database connection file
require_once 'db_connect.php';

$message = '';
$course_name = isset($_GET['course']) ? htmlspecialchars($_GET['course']) : '';
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
$price = isset($_GET['price']) ? htmlspecialchars($_GET['price']) : '';
$date = isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '';
$duration = isset($_GET['duration']) ? htmlspecialchars($_GET['duration']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Prepare SQL statement
    $sql = "INSERT INTO registrations (course_name, category, price, student_name, email, phone, student_address) 
            VALUES ('$course_name', '$category', '$price','$name', '$email', '$phone', '$address')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
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
                <!-- <label for="course_name" class="form-label">Course Name:</label> -->
                <input type="hidden" class="form-control" id="course_name" name="course_name" value="<?php echo $course_name; ?>" readonly>
            </div>
            <div class="mb-3">
                <!--<label for="category" class="form-label">Category:</label> -->
                <input type="hidden" class="form-control" id="category" name="category" value="<?php echo $category; ?>" readonly>
            </div>
            <div class="mb-3">
                <!--<label for="price" class="form-label">Price:</label>-->
                <input type="hidden" class="form-control" id="price" name="price" value="<?php echo $price; ?>" readonly>
            </div>
            <div class="mb-3">
                <!--<label for="date" class="form-label">Date:</label> -->
                <input type="hidden" class="form-control" id="date" name="date" value="<?php echo $date; ?>" readonly>
            </div>
            <div class="mb-3">
                <!--<label for="duration" class="form-label">Duration:</label> -->
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
  </footer>
</body>

</html>

