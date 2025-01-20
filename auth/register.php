<?php

session_start();

// Debugging: Check if db_connection.php is being included
if (file_exists('../db_connection.php')) {
    echo "db_connection.php is included successfully!";
} else {
    echo "Failed to include db_connection.php!";
}

require_once('../db_connection.php');  // Include the database connection

// Check if $pdo is available
if (isset($pdo)) {
    echo "PDO connection is set!";
} else {
    echo "PDO connection is NOT set!";
}

// Determine the role based on where the request is coming from
// Default role is student
if (!strpos($_SERVER['HTTP_REFERER'], 'admin_dashboard.php')) {
    $role = 'student';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before saving it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
        'role' => $role
    ]);

    // After registration, redirect to login page
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../admin_side/vendors/feather/feather.css">
    <link rel="stylesheet" href="../admin_side/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../admin_side/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../admin_side/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../admin_side/images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="../admin_side/images/logo.svg" alt="logo">
                        </div>
                        <h4>New here?</h4>
                        <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <form action="../auth/register.php" method="POST" class="pt-3">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-lg" id="exampleInputUsername1" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input" required>
                                        I agree to all Terms & Conditions
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Already have an account? <a href="login.php" class="text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="../admin_side/vendors/js/vendor.bundle.base.js"></script>
<script src="../admin_side/js/template.js"></script>
<!-- endinject -->
</body>

</html>

