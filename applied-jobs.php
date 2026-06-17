<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT a.*, j.title, j.company, j.location 
        FROM applications a 
        JOIN jobs j ON a.job_id = j.id 
        WHERE a.user_id = $user_id 
        ORDER BY a.applied_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="applied-jobs.php" class="list-group-item list-group-item-action active">Applied Jobs</a>
                <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>
        <div class="col-md-9">
            <h3 class="mb-4">My Applications</h3>
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Location</th>
                                        <th>Applied Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['company_name']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row['applied_at'])); ?></td>
                                            <td>
                                                <?php 
                                                if($row['status'] == 'pending') echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                elseif($row['status'] == 'accepted') echo '<span class="badge bg-success">Accepted</span>';
                                                else echo '<span class="badge bg-danger">Rejected</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <a href="job-details.php?id=<?php echo $row['job_id']; ?>" class="btn btn-sm btn-outline-primary">View Job</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">You haven't applied for any jobs yet.</p>
                        <div class="text-center">
                            <a href="jobs.php" class="btn btn-primary">Browse Jobs</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
