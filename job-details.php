<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$job_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM jobs WHERE id = $job_id";
$result = mysqli_query($conn, $sql);
$job = mysqli_fetch_assoc($result);

if (!$job) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Job not found.</div></div>";
    include 'includes/footer.php';
    exit;
}

$has_applied = false;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if ($user_id) {
    // Check if user has already applied
    $check_sql = "SELECT * FROM applications WHERE job_id = $job_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        $has_applied = true;
    }

    // Handle Application
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply'])) {
        if (!$has_applied) {
            $insert = "INSERT INTO applications (job_id, user_id) VALUES ($job_id, $user_id)";
            if (mysqli_query($conn, $insert)) {
                $has_applied = true;
                echo "<script>alert('Application submitted successfully!');</script>";
            } else {
                echo "<script>alert('Error applying for job.');</script>";
            }
        }
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-5">
                    <span class="badge bg-primary mb-2"><?php echo $job['category']; ?></span>
                    <h2 class="fw-bold mb-1"><?php echo $job['title']; ?></h2>
                    <h5 class="text-muted mb-3"><?php echo $job['company']; ?></h5>
                    
                    <div class="d-flex gap-4 mb-4 text-secondary">
                        <span><i class="bi bi-geo-alt-fill"></i> <?php echo $job['location']; ?></span>
                        <span><i class="bi bi-clock-fill"></i> Posted: <?php echo date('M d, Y', strtotime($job['posted_at'])); ?></span>
                        <span class="text-success fw-bold"><i class="bi bi-cash"></i> <?php echo $job['salary']; ?></span>
                    </div>

                    <hr>

                    <h5 class="fw-bold mt-4">Job Description</h5>
                    <p class="lead" style="font-size: 1rem; line-height: 1.8;">
                        <?php echo nl2br($job['description']); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Action</h5>
                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <div class="alert alert-warning">
                            Please <a href="login.php">login</a> to apply for this job.
                        </div>
                    <?php elseif($_SESSION['role'] == 'admin'): ?>
                        <div class="alert alert-info">Admin cannot apply.</div>
                    <?php else: ?>
                        <?php if($has_applied): ?>
                            <button class="btn btn-success w-100" disabled><i class="bi bi-check-circle"></i> Already Applied</button>
                        <?php else: ?>
                            <form method="POST">
                                <button type="submit" name="apply" class="btn btn-primary w-100 btn-lg">Apply Now</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
