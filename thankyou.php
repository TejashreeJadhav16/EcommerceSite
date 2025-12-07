<?php
session_start();
include('include/db.php');

// Ensure order_id is provided
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    header("Location: index.php"); // Redirect to homepage if no order_id
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? LIMIT 1");
$stmt->bind_param("s", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows !== 1) {
    echo "Order not found.";
    exit();
}

$order = $order_result->fetch_assoc();
$product_list = json_decode($order['product_list'], true);
$total_amount = number_format($order['total_amount'], 2);

include('header.php');
?>

<div class="container my-5">
    <h2>Thank You for Your Order!</h2>
    <p>Your order has been successfully placed. Below are the details:</p>

    <h4>Order ID: <?= htmlspecialchars($order['order_id']) ?></h4>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>

    <h4>Product Summary</h4>
    <ul>
        <?php foreach ($product_list as $item): ?>
            <li>
                <?= htmlspecialchars($item['name']) ?> x <?= (int)$item['qty'] ?> 
                (₹<?= number_format((float)$item['price'], 2) ?> each)
            </li>
        <?php endforeach; ?>
    </ul>

    <h4>Total Amount: ₹<?= $total_amount ?></h4>

    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
</div>

<?php include('footer.php'); ?>
