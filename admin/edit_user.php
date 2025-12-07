<?php
session_start();
include('../include/db.php');

// ✅ Allow only admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ✅ Handle form submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int) $_POST['id'];
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role  = in_array($_POST['role'], ['admin', 'user']) ? $_POST['role'] : 'user';

    if ($id > 0 && !empty($name) && !empty($email)) {
        $updateQuery = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";

        if (mysqli_query($conn, $updateQuery)) {
            $_SESSION['success'] = "User updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update user: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Invalid input data.";
    }

    header("Location: users.php");
    exit();
}

// ✅ Display form (GET)
$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($user_id <= 0) {
    $_SESSION['error'] = "Invalid user ID.";
    header("Location: users.php");
    exit();
}

// Fetch user details
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: users.php");
    exit();
}

include('header.php');
?>

<div class="container mt-4">
    <h2>Edit User</h2>

    <form action="edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<?php include('footer.php'); ?>
