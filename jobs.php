<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT * FROM jobs WHERE 1=1";

if ($search) {
    $sql .= " AND (title LIKE '%$search%' OR company_name LIKE '%$search%')";
}
if ($category) {
    $sql .= " AND category = '$category'";
}

$sql .= " ORDER BY posted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2 class="fw-bold">Browse Jobs</h2>
            <p class="text-muted">Find your dream job from our curated list.</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm p-3">
                <form class="row g-3" method="GET" action="jobs.php">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="search" placeholder="Job title or company..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="category">
                            <option value="">All Categories</option>
                            <?php
                            $cats = ['IT & Software', 'Marketing & Sales', 'Finance & Banking', 'Engineering', 'Customer Support', 'Design & Creative'];
                            foreach ($cats as $cat) {
                                $selected = ($category == $cat) ? 'selected' : '';
                                echo "<option value='$cat' $selected>$cat</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="row g-4">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-6 col-lg-4">
                    <div class="card job-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary">'.$row['category'].'</span>
                                <small class="text-muted">'.date('M d, Y', strtotime($row['posted_at'])).'</small>
                            </div>
                            <h5 class="card-title fw-bold">'.$row['title'].'</h5>
                            <h6 class="card-subtitle mb-2 text-muted">'.$row['company'].'</h6>
                            <p class="card-text text-truncate">'.substr($row['description'], 0, 100).'...</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="bi bi-geo-alt-fill"></i> '.$row['location'].'</small>
                                <small class="text-success fw-bold">'.$row['salary'].'</small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0 pb-3">
                            <div class="d-grid px-2">
                                <a href="job-details.php?id='.$row['id'].'" class="btn btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h5 class="text-muted">No jobs found matching your criteria.</h5></div>';
        }
        ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
