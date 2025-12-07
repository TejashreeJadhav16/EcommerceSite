<?php
session_start();
include('include/db.php');
include('header.php');

// Fetch all unique categories from products table
$categoriesResult = mysqli_query($conn, "SELECT DISTINCT category FROM products");
?>

<div class="container my-5">
    <h2 class="mb-4">Product Categories</h2>
    <div class="row">
        <?php if(mysqli_num_rows($categoriesResult) > 0): ?>
            <?php while($category = mysqli_fetch_assoc($categoriesResult)): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-uppercase"><?= htmlspecialchars($category['category']) ?></h5>
                            <a href="category-products.php?cat=<?= urlencode($category['category']) ?>" class="btn btn-primary mt-3">View Products</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No categories found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>
