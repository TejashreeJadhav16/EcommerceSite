<?php 
session_start();
include('header.php'); 
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<div class="container-fluid my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="bg-light p-5 rounded shadow">
        <h3 class="text-center text-uppercase mb-4">Login to Your Account</h3>

        <?php if($error) { ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form action="login-process.php" method="POST">
          <div class="form-group mb-3">
            <label for="email" class="font-weight-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
          </div>
          <div class="form-group mb-3">
            <label for="password" class="font-weight-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <input type="checkbox" id="remember" name="remember">
              <label for="remember" class="small">Remember Me</label>
            </div>
            <a href="set-password.php" class="small text-primary">Forgot Password?</a>
          </div>
          <button type="submit" class="btn btn-primary btn-block py-2">Login</button>
          <p class="text-center mt-3 mb-0">Don’t have an account? <a href="register.php" class="text-primary font-weight-bold">Register Here</a></p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
