<?php
require_once '../includes/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    // Secret key to prevent unauthorized admin registration (optional but recommended)
    // For this beginner project, we might skip it or add a simple one if the user asked, 
    // but the request is just "create account first". I'll keep it open as per request.

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if email already exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email already registered.";
        } else {
            // Register Admin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'admin'; // Set role to admin

            $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $email, $hashed_password, $role);

            if (mysqli_stmt_execute($insert_stmt)) {
                $success = "Admin account created! You can now <a href='login.php'>Login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            mysqli_stmt_close($insert_stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-lg p-4" style="width: 450px;">
    <h3 class="text-center mb-4">Create Admin Account</h3>
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-dark">Register Admin</button>
        </div>
    </form>
    <div class="text-center mt-3">
        <p>Already have an admin account? <a href="login.php" class="text-blue">Login here</a></p>
        <a href="../index.php" class="text-decoration-none text-blue">Back to Site</a>
    </div>
</div>

</body>
</html>
