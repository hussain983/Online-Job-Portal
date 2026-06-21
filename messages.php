<?php
require_once 'header.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM messages WHERE id=$id");
    echo "<script>alert('Message deleted successfully'); window.location.href='messages.php';</script>";
}

// Fetch Messages
$result = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Inquiries</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td style="width: 15%;"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td style="width: 20%;">
                                    <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                </td>
                                <td style="width: 20%;"><?php echo htmlspecialchars($row['subject']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                <td style="width: 10%;">
                                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-envelope"></i></a>
                                    <a href="messages.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this message?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
