<?php
require_once 'header.php';

// Handle Status Update
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    if (in_array($status, ['accepted', 'rejected'])) {
        $stmt = mysqli_prepare($conn, "UPDATE applications SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        echo "<script>window.location.href='applications.php';</script>";
    }
}

// Fetch Applications
$sql = "SELECT a.*, u.name as user_name, u.email as user_email, j.title as job_title, j.company 
        FROM applications a 
        JOIN users u ON a.user_id = u.id 
        JOIN jobs j ON a.job_id = j.id 
        ORDER BY a.applied_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Job Applications</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Job</th>
                        <th>Applicant</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <span class="fw-bold"><?php echo $row['job_title']; ?></span><br>
                                <small class="text-muted"><?php echo $row['company']; ?></small>
                            </td>
                            <td>
                                <span class="fw-bold"><?php echo $row['user_name']; ?></span><br>
                                <small class="text-muted"><?php echo $row['user_email']; ?></small>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($row['applied_at'])); ?></td>
                            <td>
                                <?php 
                                if($row['status'] == 'pending') echo '<span class="badge bg-warning text-dark">Pending</span>';
                                elseif($row['status'] == 'accepted') echo '<span class="badge bg-success">Accepted</span>';
                                else echo '<span class="badge bg-danger">Rejected</span>';
                                ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'pending'): ?>
                                    <a href="applications.php?id=<?php echo $row['id']; ?>&status=accepted" class="btn btn-sm btn-success me-1"><i class="bi bi-check-lg"></i></a>
                                    <a href="applications.php?id=<?php echo $row['id']; ?>&status=rejected" class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i></a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
