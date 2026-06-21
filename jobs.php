<?php
require_once 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM jobs WHERE id=$id");
    echo "<script>alert('Job deleted successfully'); window.location.href='jobs.php';</script>";
}

// Fetch Jobs
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY posted_at DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Jobs</h2>
    <a href="add-job.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add New Job</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Posted Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['title']; ?></td>
                            <td><?php echo $row['company']; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $row['category']; ?></span></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['posted_at'])); ?></td>
                            <td>
                                <a href="edit-job.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                <a href="jobs.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
