<?php
session_start();
include("include/db.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    $_SESSION['error'] = "Please fill all fields.";
    header("Location: login.php");
    exit();
}

// Fetch user
$stmt = $conn->prepare("SELECT id,name,email,password,role,profile_image FROM users WHERE email=? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_profile'] = $user['profile_image'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Invalid password.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit();
}
