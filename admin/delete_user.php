<?php
session_start();
include('../include/db.php');

// ✅ Allow only admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// ✅ Validate and sanitize the user ID
$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($user_id > 0) {
    // Prevent admin from deleting themselves
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot delete your own account.";
    } else {
        $deleteQuery = "DELETE FROM users WHERE id = $user_id";
        if (mysqli_query($conn, $deleteQuery)) {
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
    }
} else {
    $_SESSION['error'] = "Invalid user ID.";
}

// Redirect back to users.php
header("Location: users.php");
exit();
