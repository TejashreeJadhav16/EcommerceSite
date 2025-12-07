<?php
session_start();
include('../include/db.php');

// ✅ Admin check
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Check if ID is passed
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = intval($_GET['id']);
$message = "";

// ✅ Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Product not found!</div>";
    exit();
}
$product = $result->fetch_assoc();
$stmt->close();

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $color = trim($_POST['color']);
    $size = trim($_POST['size']);
    $imagePath = $product['image']; // Keep current image if not updated

    // ✅ Handle image upload if new image provided
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $message = "<div class='alert alert-danger'>Only JPG, PNG, and WEBP images are allowed.</div>";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $message = "<div class='alert alert-danger'>Image size must be less than 2MB.</div>";
        } else {
            $targetDir = "../uploads/products/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $safeFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES["image"]["name"]));
            $fileName = time() . "_" . $safeFileName;
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = "uploads/products/" . $fileName;
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload image.</div>";
            }
        }
    }

    // ✅ Update database
    if (empty($message)) {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, color=?, size=?, image=? WHERE id=?");
        $stmt->bind_param("ssdssssi", $name, $description, $price, $category, $color, $size, $imagePath, $id);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Product updated successfully!</div>";
            // Refresh product data
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>Database error: " . $stmt->error . "</div>";
        }
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
            <a href="index.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="products.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-boxes me-2"></i> Products</a>
            <a href="users.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-users me-2"></i> Users</a>
            <a href="orders.php" class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'bg-secondary rounded' : '' ?>"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
            <a href="../index.php" class="d-block py-2 px-3 text-white"><i class="fas fa-home me-2"></i> View Site</a>
            <a href="../logout.php" class="d-block py-2 px-3 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>

        <!-- Edit Product Form -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Edit Product</h2>

            <?= $message ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        <option value="Bedsheets" <?= $product['category']=='Bedsheets'?'selected':'' ?>>Bedsheets</option>
                        <option value="Comforters" <?= $product['category']=='Comforters'?'selected':'' ?>>Comforters</option>
                        <option value="Curtains" <?= $product['category']=='Curtains'?'selected':'' ?>>Curtains</option>
                        <option value="Pillows" <?= $product['category']=='Pillows'?'selected':'' ?>>Pillows</option>
                        <option value="Dohars" <?= $product['category']=='Dohars'?'selected':'' ?>>Dohars</option>
                        <option value="Bath Towels" <?= $product['category']=='Bath Towels'?'selected':'' ?>>Bath Towels</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="<?= $product['price'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="<?= htmlspecialchars($product['color']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Size</label>
                    <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($product['size']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <?php if(!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars('../' . $product['image']) ?>" alt="Product Image" style="max-width:150px;margin-bottom:10px;">
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="products.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
