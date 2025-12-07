<?php
session_start();
include("include/db.php");

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Set role to 'user' by default
$role = 'user';

// Validate passwords
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match!";
    header("Location: register.php");
    exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Email already registered!";
    header("Location: register.php");
    exit();
}
$stmt->close();

// Handle profile image
$profile_image = null;
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9_-]/", "", pathinfo($_FILES['profile_image']['name'], PATHINFO_FILENAME)) . '.' . $ext;

    // Ensure folder exists
    $upload_dir = __DIR__ . '/uploads/profile_images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $filename);
    $profile_image = 'uploads/profile_images/' . $filename;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$stmt = $conn->prepare("INSERT INTO users (name,email,phone,address,password,role,profile_image) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $address, $hashed_password, $role, $profile_image);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful! Please login.";
    header("Location: login.php");
} else {
    $_SESSION['error'] = "Something went wrong, please try again.";
    header("Location: register.php");
}

$stmt->close();
$conn->close();
