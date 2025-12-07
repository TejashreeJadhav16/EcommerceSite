<?php
session_start();
include('../include/db.php');

// ✅ Allow only admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('header.php');

// ✅ Fetch all users
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
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
            <h1 class="mb-4">Manage Users</h1>

            <!-- ✅ Flash Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td>
                                            <img src="../<?= htmlspecialchars($row['profile_image'] ?: 'img/default-profile.png') ?>"
                                                 alt="Profile" class="rounded-circle"
                                                 style="width:40px; height:40px; object-fit:cover;">
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['role'] === 'admin' ? 'danger' : 'secondary' ?>">
                                                <?= ucfirst($row['role']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="delete_user.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('footer.php'); ?>
