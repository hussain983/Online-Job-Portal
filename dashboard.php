<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT COUNT(*) as total_apps FROM applications WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_applied = $row['total_apps'];
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="applied-jobs.php" class="list-group-item list-group-item-action">Applied Jobs</a>
                <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>
        <div class="col-md-9">
            <h2 class="mb-4">Welcome, <?php echo $_SESSION['name']; ?>!</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-primary text-white shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Applied Jobs</h5>
                            <h1><?php echo $total_applied; ?></h1>
                            <a href="applied-jobs.php" class="btn btn-light btn-sm mt-2">View List</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Profile Status</h5>
                            <p class="mb-1">Active</p>
                            <a href="profile.php" class="btn btn-light btn-sm mt-3">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
