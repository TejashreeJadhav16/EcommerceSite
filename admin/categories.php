<?php
ob_start(); // Start output buffering
session_start();
include('../include/db.php');

// ✅ Only allow admins
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// -------------------------
// Handle Add Category
// -------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = strtolower(str_replace(' ', '-', $name));
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/category_images/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = "uploads/category_images/" . $imageName;
        }
    }

    $insertQuery = "INSERT INTO categories (name, slug, image) VALUES ('$name', '$slug', '$image')";
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: categories.php?success=Category added successfully");
        exit();
    } else {
        die("Error adding category: " . mysqli_error($conn));
    }
}

// -------------------------
// Handle Delete Category
// -------------------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM categories WHERE id=$id";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: categories.php?success=Category deleted successfully");
        exit();
    } else {
        die("Error deleting category: " . mysqli_error($conn));
    }
}

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
            <a href="categories.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'categories.php' ? 'bg-secondary rounded' : '' ?>">
                <i class="fas fa-tags me-2"></i> Categories
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
            <h1 class="mb-4">Manage Categories</h1>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <!-- Add Category Form -->
            <div class="card mb-4 p-3 shadow-sm">
                <h5>Add New Category</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" name="add_category" class="btn btn-primary w-100">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Category Table -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
                    if ($result && mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="../<?= $row['image'] ?>" width="60" class="rounded">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['slug']) ?></td>
                        <td>
                            <a href="edit_category.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="categories.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">No categories found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
ob_end_flush(); // flush output buffer
?>
