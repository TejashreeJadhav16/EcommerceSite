<?php
session_start();
include('include/db.php');

// Redirect if user not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT name, email, phone, address, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$profile_image = $user['profile_image'] ?? 'default-avatar.png';

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Handle profile image upload
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0){
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_image = "uploads/profile_" . $user_id . "." . $ext;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $new_image);
    } else {
        $new_image = $profile_image; // Keep old image
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, address=?, profile_image=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $phone, $address, $new_image, $user_id);
    $stmt->execute();

    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: edit-profile.php");
    exit;
}
?>

<?php include('header.php'); ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow">
        <div class="card-header text-center"><h3>Edit Profile</h3></div>
        <div class="card-body">
          <?php if(!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
          <?php endif; ?>
          <form method="POST" enctype="multipart/form-data">
            <div class="text-center mb-3">
              <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile" class="rounded-circle" style="width:120px; height:120px; object-fit:cover;">
            </div>
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Profile Image</label>
              <input type="file" name="profile_image" class="form-control">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update Profile</button>
              <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
