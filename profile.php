<?php
session_start();
include('include/db.php'); // Your DB connection

// Redirect if user not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, phone, address, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $email = $user['email'];
    $phone = $user['phone'];
    $address = $user['address'];
    $profile_image = $user['profile_image'] ?? 'default-avatar.png'; // fallback
} else {
    header("Location: login.php");
    exit;
}
?>

<?php include('header.php'); ?> <!-- Header with navbar -->

<!-- Profile Card -->
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow">
        <div class="card-header text-center">
          <h3>Your Profile</h3>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile Picture" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
            <h4 class="mt-3"><?= htmlspecialchars($name) ?></h4>
            <p class="text-muted"><?= htmlspecialchars($email) ?></p>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Full Name</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($name) ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Email</label>
              <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Phone</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($phone) ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Address</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($address) ?>" readonly>
            </div>
          </div>

          <div class="text-center mt-4">
            <a href="edit-profile.php" class="btn btn-primary me-2">Edit Profile</a>
            <a href="change-password.php" class="btn btn-secondary">Change Password</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?> <!-- Footer -->
