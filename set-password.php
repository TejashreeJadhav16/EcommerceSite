<?php
session_start();
include("header.php"); // Include the header
include("include/db.php");

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
?>

<div class="container-fluid my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="bg-light p-5 rounded shadow">
        <h3 class="text-center text-uppercase mb-4">Set Your Password</h3>

        <?php if($error) { ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php } elseif($success) { ?>
          <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php } ?>

        <form action="set-password-process.php" method="POST">
          <div class="form-group mb-3">
            <label for="email" class="font-weight-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your registered email" required>
          </div>
          <div class="form-group mb-3">
            <label for="password" class="font-weight-bold">New Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your new password" required>
          </div>
          <div class="form-group mb-3">
            <label for="confirm_password" class="font-weight-bold">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your new password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block py-2">Set Password</button>
          <p class="text-center mt-3 mb-0">
            Remembered your password? <a href="login.php" class="text-primary font-weight-bold">Login Here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); // Include footer ?>
