<?php
session_start();
include('include/db.php');
include('header.php');

// Safe default cart initialization
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fetch Dohars from DB
$dbProducts = mysqli_query($conn, "SELECT * FROM products WHERE category='Dohars'");
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-3 col-md-4">
            <?php 
            $category = 'dohars'; // dynamically sets sidebar
            include('shop-sidebar.php'); 
            ?>
        </div>

        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <h2 class="mb-4">Dohars Collection</h2>
                </div>

                <!-- Dynamic DB Dohars -->
                <?php if (mysqli_num_rows($dbProducts) > 0): ?>
                    <?php while ($p = mysqli_fetch_assoc($dbProducts)): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">

                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="cart.php?add=<?= $p['id'] ?>">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square" href="wishlist-action.php?add=<?= $p['id'] ?>">
                                            <i class="far fa-heart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>

                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="#"><?= htmlspecialchars($p['name']) ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>₹<?= number_format($p['price'], 2) ?></h5>
                                        <?php if (!empty($p['old_price'])): ?>
                                            <h6 class="text-muted ml-2"><del>₹<?= number_format($p['old_price'], 2) ?></del></h6>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p>No Dohars available at the moment.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
