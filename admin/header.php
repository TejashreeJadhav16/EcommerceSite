<?php
// admin/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure only admin users can access
if (empty($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

// Profile image setup
$profile_img = '../img/default-profile.png'; // default fallback image

if (!empty($_SESSION['user_profile'])) {
    $profile_path = __DIR__ . '/../' . $_SESSION['user_profile'];
    if (file_exists($profile_path)) {
        $profile_img = '../' . $_SESSION['user_profile']; // prepend ../ since we are in admin/
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Nidra Homes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-yellow: #FFD700;
            --dark-gray: #333333;
            --light-gray: #f8f9fa;
        }

        /* Top bar */
        .top-bar {
            background-color: var(--light-gray);
            font-size: 0.9rem;
            padding: 5px 0;
        }
        .top-bar a { color: var(--dark-gray); text-decoration: none; margin-right: 15px; }
        .top-bar a:hover { text-decoration: underline; }

        /* Header */
        .header-main {
            background-color: var(--dark-gray);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-main .logo { font-weight: bold; font-size: 1.5rem; }
        .header-main .logo span { background-color: var(--primary-yellow); color: var(--dark-gray); padding: 0 5px; }

        .header-main .search-bar input { width: 200px; }
        .header-main .search-bar button { background-color: var(--primary-yellow); border: none; color: var(--dark-gray); }

        /* Navbar */
        .navbar-admin { background-color: var(--primary-yellow); }
        .navbar-admin .nav-link { color: var(--dark-gray); }
        .navbar-admin .nav-link:hover { color: #fff; }
        .navbar-admin .dropdown-item:hover { color: var(--primary-yellow); }

        /* Profile image */
        .profile-img { width: 40px; height: 40px; object-fit: cover; }
        .dropdown-profile img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>


<!-- Header Main -->
<div class="header-main">
    <div class="logo">NIDRA <span>HOMES</span></div>
    <!-- Top Info Bar -->
<div class="top-bar d-flex justify-content-end pe-3">
    <a href="../about-us.php">About</a>
    <a href="../contact-us.php">Contact</a>
    <a href="#">Help</a>
    <a href="#">FAQs</a>
</div>

</div>

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-admin">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= htmlspecialchars($profile_img) ?>" alt="Profile" class="rounded-circle me-2 profile-img" style="width:35px; height:35px; object-fit:cover;">
            <?= htmlspecialchars($_SESSION['user_name']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-profile">
            <li><a class="dropdown-item" href="../profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </li>
</ul>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4">
<!-- Page content starts here -->
