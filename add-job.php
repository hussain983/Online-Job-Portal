<?php
require_once 'header.php';

$msg = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $company = trim($_POST['company']);
    $category = $_POST['category'];
    $location = trim($_POST['location']);
    $salary = trim($_POST['salary']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($company) || empty($description)) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO jobs (title, company, category, location, salary, description) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $title, $company, $category, $location, $salary, $description);
        
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Job posted successfully!";
        } else {
            $error = "Error posting job.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Job</h4>
            </div>
            <div class="card-body">
                <?php if ($msg): ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="IT & Software">IT & Software</option>
                                <option value="Marketing & Sales">Marketing & Sales</option>
                                <option value="Finance & Banking">Finance & Banking</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Customer Support">Customer Support</option>
                                <option value="Design & Creative">Design & Creative</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary (Optional)</label>
                            <input type="text" name="salary" class="form-control" placeholder="e.g. $50,000 - $70,000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job Description</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Post Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
