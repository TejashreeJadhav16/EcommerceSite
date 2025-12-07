<?php
session_start();
include('../include/db.php');

// ✅ Admin check
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $imagePath = '';

    // ✅ Validate basic fields
    if (empty($name) || empty($price) || empty($category)) {
        $message = "<div class='alert alert-danger'>Please fill in all required fields.</div>";
    } else {
        // ✅ Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            $fileSize = $_FILES['image']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                $message = "<div class='alert alert-danger'>Only JPG, PNG, and WEBP images are allowed.</div>";
            } elseif ($fileSize > 2 * 1024 * 1024) { // 2MB limit
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

        // ✅ Insert into database using prepared statements
        if (empty($message)) {
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $name, $description, $price, $imagePath, $category);

            if ($stmt->execute()) {
                header("Location: products.php?success=1");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Database error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    }
}

include('header.php');

?>
<div class="container-fluid">
    <div class="row">
                 <div class="col-md-3 col-lg-2 sidebar bg-dark text-white p-3">
            <div class="text-center mb-4">
                <img src="<?= htmlspecialchars(!empty($_SESSION['user_profile']) ? '../' . $_SESSION['user_profile'] : '../img/default-profile.png') ?>"
                     alt="Admin" class="rounded-circle mb-2" style="width:70px;height:70px;object-fit:cover;">
                <h6 class="mb-0"><?= htmlspecialchars($_SESSION['user_name']) ?></h6>
                <small><?= htmlspecialchars($_SESSION['user_email']) ?></small>
            </div>
            <a href="index.php" 
   class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'bg-secondary rounded' : '' ?>">
   <i class="fas fa-tachometer-alt me-2"></i> Dashboard
</a>

<a href="products.php" 
   class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'products.php' ? 'bg-secondary rounded' : '' ?>">
   <i class="fas fa-boxes me-2"></i> Products
</a>



<a href="users.php" 
   class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'users.php' ? 'bg-secondary rounded' : '' ?>">
   <i class="fas fa-users me-2"></i> Users
</a>

<a href="orders.php" 
   class="d-block py-2 px-3 text-white <?= basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'bg-secondary rounded' : '' ?>">
   <i class="fas fa-shopping-cart me-2"></i> Orders
</a>

<a href="../index.php" class="d-block py-2 px-3 text-white">
   <i class="fas fa-home me-2"></i> View Site
</a>

<a href="../logout.php" class="d-block py-2 px-3 text-danger">
   <i class="fas fa-sign-out-alt me-2"></i> Logout
</a>

        </div>
<div class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Add Product</h2>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <option value="Comforters">Comforters</option>
                <option value="Bedsheets">Bedsheets</option>
                <option value="Dohars">Dohars</option>
                <option value="Towels">Bath Towels</option>
                <option value="Pillows">Pillows</option>
                <option value="Curtains">Curtains</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (₹)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>

<?php include('footer.php'); ?>
