<?php
require_once 'header.php';

// Fetch stats
$jobs_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs"))['count'];
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role='user'"))['count'];
$apps_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM applications"))['count'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admin Dashboard</h2>
    <a href="add-job.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Post New Job</a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Jobs</h5>
                        <h2 class="display-4 fw-bold"><?php echo $jobs_count; ?></h2>
                    </div>
                    <i class="bi bi-briefcase fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="jobs.php" class="text-white text-decoration-none">Manage Jobs &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Registered Users</h5>
                        <h2 class="display-4 fw-bold"><?php echo $users_count; ?></h2>
                    </div>
                    <i class="bi bi-people fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="users.php" class="text-white text-decoration-none">Manage Users &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning shadow-sm h-100">
            <div class="card-body text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Applications</h5>
                        <h2 class="display-4 fw-bold"><?php echo $apps_count; ?></h2>
                    </div>
                    <i class="bi bi-file-earmark-person fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="applications.php" class="text-dark text-decoration-none">View All &rarr;</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
