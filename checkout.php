<?php
session_start();
include('include/db.php');

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, phone, address FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Initialize error message
$error = '';

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name && $email && $phone && $address) {
        // Calculate total
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item) {
            $total += floatval($item['price']) * intval($item['qty']);
        }

        // Generate unique order ID
        $order_id = 'ORD' . time() . rand(100,999);

        // Convert cart to JSON
        $product_list = json_encode($_SESSION['cart'], JSON_UNESCAPED_UNICODE);

        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (order_id, user_id, product_list, total_amount, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())");
        $stmt->bind_param("sisd", $order_id, $user_id, $product_list, $total);

        if ($stmt->execute()) {
            // Clear cart
            unset($_SESSION['cart']);

            // Redirect to thank you page
            header("Location: thankyou.php?order_id=".$order_id);
            exit();
        } else {
            $error = "Failed to place order. MySQL error: " . $stmt->error;
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}

include('header.php');
?>

<div class="container my-5">
    <h2>Checkout</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Billing Details -->
        <div class="col-md-6">
            <h4>Billing Details</h4>
            <form method="POST">
                <div class="mb-3">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>">
                </div>
                <div class="mb-3">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
                </div>
                <div class="mb-3">
                    <label>Phone *</label>
                    <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($user['phone']) ?>">
                </div>
                <div class="mb-3">
                    <label>Address *</label>
                    <textarea name="address" class="form-control" rows="3" required><?= htmlspecialchars($user['address']) ?></textarea>
                </div>
                <button type="submit" name="place_order" class="btn btn-success">Place Order</button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-md-6">
            <h4>Order Summary</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach($_SESSION['cart'] as $item):
                        $subtotal = floatval($item['price']) * intval($item['qty']);
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= intval($item['qty']) ?></td>
                        <td>₹<?= number_format($subtotal,2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                        <td><strong>₹<?= number_format($total,2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
