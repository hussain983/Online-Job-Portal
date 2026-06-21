<?php
require_once 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM jobs WHERE id = $id");
$job = mysqli_fetch_assoc($query);

if (!$job) {
    echo "<div class='alert alert-danger'>Job not found.</div>";
    require_once 'footer.php';
    exit;
}

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
        $stmt = mysqli_prepare($conn, "UPDATE jobs SET title=?, company_name=?, category=?, location=?, salary=?, description=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $title, $company, $category, $location, $salary, $description, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Job updated successfully!";
            // Refresh data
            $job['title'] = $title;
            $job['company_name'] = $company;
            $job['category'] = $category;
            $job['location'] = $location;
            $job['salary'] = $salary;
            $job['description'] = $description;
        } else {
            $error = "Error updating job.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Job</h4>
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
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company" class="form-control" value="<?php echo htmlspecialchars($job['company_name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php
                                $categories = ['IT & Software', 'Marketing & Sales', 'Finance & Banking', 'Engineering', 'Customer Support', 'Design & Creative'];
                                foreach ($categories as $cat) {
                                    $selected = ($job['category'] == $cat) ? 'selected' : '';
                                    echo "<option value='$cat' $selected>$cat</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($job['location']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary (Optional)</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo htmlspecialchars($job['salary']); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job Description</label>
                        <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">Update Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
