<?php
session_start();
require_once '../includes/config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter email and password.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, name, password, role FROM users WHERE email = ? AND role = 'admin'");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password, $role);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Access Denied. Admin account not found.";
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
    <title>Admin Login - Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-lg p-4" style="width: 400px;">
    <h3 class="text-center mb-4">Admin Login</h3>
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-dark">Login</button>
        </div>
    </form>
    <div class="text-center mt-3">
        <p class="text-white">Need an account? <a href="register.php" class="text-white fw-bold">Create New Admin Account</a></p>
        <a href="../index.php" class="text-decoration-none text-blue">Back to Site</a>
    </div>
     <div class="card-footer text-center">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
</div>

</body>
</html>
