<?php
session_start();
include('../include/db.php');

// ✅ Allow only admins
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ✅ Fetch products
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

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

            <a href="index.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="products.php" class="d-block py-2 px-3 text-white bg-secondary rounded"><i class="fas fa-boxes me-2"></i> Products</a>
            <a href="users.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-users me-2"></i> Users</a>
            <a href="orders.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
            <a href="../index.php" class="d-block py-2 px-3 text-white"><i class="fas fa-home me-2"></i> View Site</a>
            <a href="../logout.php" class="d-block py-2 px-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2 class="h4">Products</h2>
                <a href="add_product.php" class="btn btn-success">+ Add Product</a>
            </div>

            <div class="table-responsive shadow rounded bg-white p-3">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td>₹<?= number_format($row['price']) ?></td>
                                    <td>
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="../<?= htmlspecialchars($row['image']) ?>" 
                                                 alt="<?= htmlspecialchars($row['name']) ?>" 
                                                 width="60" class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this product?')">
                                           <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include('footer.php'); ?>
