<?php
session_start();
include("include/db.php");
include('header.php');


?>

<div class="container-fluid my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="bg-light p-5 rounded shadow">
        <h3 class="text-center text-uppercase mb-4">Track Your Order</h3>

        <?php
        if(isset($_POST['order_id'], $_POST['email'])){
            include('include/db.php'); // Database connection

            $order_id = trim($_POST['order_id']);
            $email = trim($_POST['email']);

            $stmt = $conn->prepare("
                SELECT o.*, u.email 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.order_id = ? AND u.email = ?
            ");
            $stmt->bind_param("ss", $order_id, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $order = $result->fetch_assoc();
                echo "<div class='alert alert-success'>
                        <p><strong>Order ID:</strong> ".htmlspecialchars($order['order_id'])."</p>
                        <p><strong>Status:</strong> ".htmlspecialchars($order['status'])."</p>
                        <p><strong>Total:</strong> ₹".htmlspecialchars($order['total_amount'])."</p>
                      </div>";
            } else {
                echo "<div class='alert alert-danger'>Order not found. Please check your Order ID and Email.</div>";
            }
        }
        ?>

        <!-- Track Order Form -->
        <form action="" method="POST">
          <div class="form-group mb-3">
            <label for="order_id" class="fw-bold">Order ID</label>
            <input type="text" name="order_id" id="order_id" class="form-control" placeholder="Enter your Order ID" required>
          </div>

          <div class="form-group mb-3">
            <label for="email" class="fw-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2">Track Order</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include('footer.php'); // Footer
?>
