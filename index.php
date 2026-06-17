<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<div class="hero-section text-white d-flex align-items-center justify-content-center" style="height: 60vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;">
    <div class="text-center container">
        <h1 class="display-3 fw-bold">Find Your First Job as a Fresh Graduate</h1>
        <p class="lead mb-4">Discover the best career opportunities tailored for freshers.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="jobs.php" class="btn btn-primary btn-lg px-4">Browse Jobs</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-outline-light btn-lg px-4">Logout</a>
            <?php else: ?>
                <a href="register.php" class="btn btn-outline-light btn-lg px-4">Register Now</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Category Section -->
<div class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Popular Categories</h2>
    <div class="row g-4">
        <?php
        $categories = ['IT & Software', 'Marketing & Sales', 'Finance & Banking', 'Engineering', 'Customer Support', 'Design & Creative'];
        foreach ($categories as $cat) {
            echo '
            <div class="col-md-4 col-sm-6">
                <div class="card category-card text-center p-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">'.$cat.'</h5>
                        <p class="card-text text-muted">View Openings</p>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<!-- Featured Jobs Section -->
<div class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Featured Jobs</h2>
    <div class="row g-4">
        <?php
        // Fetch latest 5 jobs
        $sql = "SELECT * FROM jobs ORDER BY posted_at DESC LIMIT 6";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-md-4">
                    <div class="card job-card h-100">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">'.$row['category'].'</span>
                            <h5 class="card-title fw-bold">'.$row['title'].'</h5>
                            <h6 class="card-subtitle mb-2 text-muted">'.$row['company'].'</h6>
                            <p class="card-text text-truncate">'.substr($row['description'], 0, 100).'...</p>
                            <p class="small text-muted mb-0"><i class="bi bi-geo-alt-fill"></i> '.$row['location'].'</p>
                            <p class="small text-muted"><i class="bi bi-cash"></i> '.$row['salary'].'</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <div class="d-grid">
                                <a href="job-details.php?id='.$row['id'].'" class="btn btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center"><p class="text-muted">No jobs posted yet.</p></div>';
        }
        ?>
    </div>
    <div class="text-center mt-5">
        <a href="jobs.php" class="btn btn-primary btn-lg">View All Jobs</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
