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
        <h3 class="text-center text-uppercase mb-4">Create Your Account</h3>

        <?php if($error) { ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form action="register-process.php" method="POST" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="name" class="font-weight-bold">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
          </div>

          <div class="form-group mb-3">
            <label for="email" class="font-weight-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
          </div>

          <div class="form-group mb-3">
            <label for="phone" class="font-weight-bold">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
          </div>

          <div class="form-group mb-3">
            <label for="address" class="font-weight-bold">Address</label>
            <textarea name="address" id="address" class="form-control" placeholder="Enter your address"></textarea>
          </div>

          <div class="form-group mb-3">
            <label for="password" class="font-weight-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
          </div>

          <div class="form-group mb-3">
            <label for="confirm_password" class="font-weight-bold">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
          </div>

          <div class="form-group mb-3">
            <label for="profile_image" class="font-weight-bold">Profile Image (optional)</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
          </div>

          <!-- Role selection -->
          <!--<div class="form-group mb-3">
            <label for="role" class="font-weight-bold">Role</label>
            <select name="role" id="role" class="form-control">
              <option value="user" selected>User</option>
              <option value="admin">Admin</option>
            </select>
          </div>-->

          <button type="submit" class="btn btn-primary btn-block py-2">Register</button>

          <p class="text-center mt-3 mb-0">Already have an account? 
            <a href="login.php" class="text-primary font-weight-bold">Login Here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
