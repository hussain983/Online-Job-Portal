<?php
require_once 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Prevent deleting self or admins
    $check = mysqli_query($conn, "SELECT role FROM users WHERE id=$id");
    $user = mysqli_fetch_assoc($check);
    
    if ($user && $user['role'] != 'admin') {
        mysqli_query($conn, "DELETE FROM users WHERE id=$id");
        echo "<script>alert('User deleted successfully'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Cannot delete admin users or invalid user.'); window.location.href='users.php';</script>";
    }
}

// Fetch Users
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Users</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="users.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user? This will also delete their applications.');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
