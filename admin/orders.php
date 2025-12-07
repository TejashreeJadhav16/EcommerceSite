<?php
session_start();

// ✅ Only allow admins
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ✅ Include database connection
include('../include/db.php');

// Include header
include('header.php');
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
            <a href="index.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-secondary rounded' : '' ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="products.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'bg-secondary rounded' : '' ?>">
                <i class="fas fa-boxes me-2"></i> Products
            </a>
            
            <a href="users.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'bg-secondary rounded' : '' ?>">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a href="orders.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'bg-secondary rounded' : '' ?>">
                <i class="fas fa-shopping-cart me-2"></i> Orders
            </a>
            <a href="../index.php" class="d-block py-2 px-3 text-white">
                <i class="fas fa-home me-2"></i> View Site
            </a>
            <a href="../logout.php" class="d-block py-2 px-3 text-danger">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h1 class="mb-4">Orders</h1>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch orders with customer info
                    $result = mysqli_query($conn, "
                        SELECT o.*, u.name AS customer_name, u.email AS customer_email
                        FROM orders o
                        LEFT JOIN users u ON o.user_id = u.id
                        ORDER BY o.created_at DESC
                    ");

                    while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['customer_name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['customer_email'] ?? 'N/A') ?></td>
                        <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                        <td>
                            <span class="badge 
                                <?php 
                                    echo match($row['status']) {
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-primary',
                                        'processing' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="update_order.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-<?= $row['status'] === 'pending' ? 'success' : 'warning' ?>">
                                <i class="fas <?= $row['status'] === 'pending' ? 'fa-check' : 'fa-edit' ?>"></i>
                                <?= $row['status'] === 'pending' ? 'Confirm' : 'Update' ?>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
