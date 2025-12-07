<?php
session_start();
include("include/db.php");
include('header.php');

// ✅ Get logged-in user ID (redirect if not logged in)
if (!isset($_SESSION['user_id'])) {
    echo "<div class='container text-center my-5'>
            <h4>Please <a href='login.php'>login</a> to view your wishlist.</h4>
          </div>";
    include('footer.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// ✅ Fetch Wishlist Items for this user
$stmt = $conn->prepare("
    SELECT w.id AS wishlist_id, p.id, p.name, p.price, p.image
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ?
    ORDER BY w.added_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid my-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="bg-light p-4 rounded shadow">
        <h3 class="text-center text-uppercase mb-4">My Wishlist</h3>

        <?php if ($result->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table text-center align-middle mb-0">
              <thead class="bg-primary text-white">
                <tr>
                  <th>Product</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Add to Cart</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td>
                      <img src="<?= htmlspecialchars($row['image']) ?>" 
                           alt="<?= htmlspecialchars($row['name']) ?>" 
                           style="width:80px; border-radius:8px;">
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>₹<?= number_format($row['price'], 2) ?></td>
                    <td>
                      <form method="post" action="cart.php" class="d-inline">
    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
    <button class="btn btn-sm btn-success">
        <i class="fa fa-shopping-cart"></i> Add
    </button>
</form>

                    </td>
                    <td>
                      <a href="wishlist-action.php?remove=<?= $row['wishlist_id'] ?>" 
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Remove this item from wishlist?');">
                        <i class="fa fa-times"></i>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center">
            <h5>Your wishlist is empty!</h5>
            <a href="shop.php" class="btn btn-primary mt-3">Continue Shopping</a>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php
$stmt->close();
include('footer.php');
?>
