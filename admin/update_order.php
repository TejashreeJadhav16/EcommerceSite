<?php
session_start();

// ✅ Only allow admins
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include('../include/db.php');

$order_id = intval($_GET['id'] ?? 0);

// ✅ Fetch order details
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id"));
if (!$order) {
    die("Order not found.");
}

// ✅ Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $update = mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$order_id");

    if ($update) {
        // ✅ Notify Customer via Email
        $to = $order['customer_email'];
        $subject = "Order #$order_id Status Update";
        $message = "Hello {$order['customer_name']},\n\nYour order #$order_id status has been updated to: $status.\n\nThank you for shopping with us!";
        $headers = "From: no-reply@nidhrahomes.com";

        @mail($to, $subject, $message, $headers);

        header("Location: orders.php?success=Order #$order_id updated successfully");
        exit();
    } else {
        echo "Failed to update order.";
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
            <h1 class="mb-4">Update Order #<?= $order_id ?></h1>

            <div class="card p-4 shadow-sm">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <input type="text" class="form-control" value="<?= ucfirst($order['status']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Change Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="confirmed" <?= $order['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Status</button>
                    <a href="orders.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
