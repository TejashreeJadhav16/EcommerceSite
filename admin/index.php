<?php
session_start();

// Only allow admins
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('header.php'); // ✅ Use your admin header.php
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar bg-dark text-white p-3">
            <div class="text-center mb-4">
                <img src="<?= htmlspecialchars(!empty($_SESSION['user_profile']) ? '../' . $_SESSION['user_profile'] : '../img/default-profile.png') ?>"
                     alt="Admin" class="rounded-circle mb-2" style="width:70px;height:70px;object-fit:cover;">
                <h6 class="mb-0"><?= htmlspecialchars($_SESSION['user_name']) ?></h6>
                <small><?= htmlspecialchars($_SESSION['user_email']) ?></small>
            </div>
            <a href="index.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="products.php" class="d-block py-2 px-3 text-white"><i class="fas fa-boxes me-2"></i> Products</a>
            <a href="users.php" class="d-block py-2 px-3 text-white"><i class="fas fa-users me-2"></i> Users</a>
            <a href="orders.php" class="d-block py-2 px-3 text-white"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
            <a href="../index.php" class="d-block py-2 px-3 text-white"><i class="fas fa-home me-2"></i> View Site</a>
            <a href="../logout.php" class="d-block py-2 px-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>

        <!-- Dashboard Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h1 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h1>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-center p-3 shadow-sm">
                        <i class="fas fa-boxes fa-2x text-primary mb-2"></i>
                        <h5>Products</h5>
                        <p class="text-muted">Manage all products</p>
                        <a href="products.php" class="btn btn-primary btn-sm">Go</a>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="card text-center p-3 shadow-sm">
                        <i class="fas fa-users fa-2x text-warning mb-2"></i>
                        <h5>Users</h5>
                        <p class="text-muted">View registered users</p>
                        <a href="users.php" class="btn btn-warning btn-sm text-white">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); // ✅ Use your admin footer ?>
