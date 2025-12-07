<?php
session_start();
include('include/db.php');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ ADD PRODUCT
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];

    $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $p = $res->fetch_assoc();

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name'  => $p['name'],
                'price' => (float)$p['price'],  // Fixed unit price
                'image' => $p['image'],
                'qty'   => 1
            ];
        }
    }

    header("Location: cart.php");
    exit();
}

// ✅ REMOVE PRODUCT
if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit();
}

// ✅ UPDATE QUANTITIES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $id  = (int)$id;
        $qty = (int)$qty;

        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }

    header("Location: cart.php");
    exit();
}

include('header.php');
?>

<div class="container my-5">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST" action="cart.php">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price (₹)</th>
                    <th>Quantity</th>
                    <th>Subtotal (₹)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $item):
                    $unitPrice = (float)$item['price'];
                    $qty       = (int)$item['qty'];
                    $subtotal  = $unitPrice * $qty;
                    $total    += $subtotal;
                ?>
                <tr>
                    <td>
                        <img src="<?= htmlspecialchars($item['image']) ?>" width="60" class="me-2">
                        <?= htmlspecialchars($item['name']) ?>
                    </td>
                    <td>₹<?= number_format($unitPrice, 2) ?></td>
                    <td>
                        <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>" min="1" class="form-control" style="width:80px;">
                    </td>
                    <td>₹<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <a href="cart.php?remove=<?= $id ?>" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2">₹<?= number_format($total, 2) ?></td>
                </tr>
            </tbody>
        </table>

        <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </form>
    <?php else: ?>
        <p>Your cart is empty. <a href="index.php">Shop Now</a></p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
