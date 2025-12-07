<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nidra Homes</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .product-img {
            width: 100%;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #fff;
        }
        .product-img img {
            height: 100%;
            width: auto;
            object-fit: cover;
        }
        .breadcrumb-about {
            background-color: transparent;
        }
        .breadcrumb-about .breadcrumb-item a {
            color: #FFD700;
            font-weight: 500;
        }
        .breadcrumb-about .breadcrumb-item a:hover {
            color: #FFA500;
        }
        .breadcrumb-about .breadcrumb-item.active {
            color: #000000;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="about-us.php">About</a>
                    <a class="text-body mr-3" href="contact-us.php">Contact</a>
                    <a class="text-body mr-3" href="help.php">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
<?php

// Default profile image
$default_img = 'img/default-profile.png';
$profile_img = $default_img;

// Only proceed if user is logged in
if (!empty($_SESSION['user_id'])) {
    $db_img = $_SESSION['user_profile'] ?? '';

    if (!empty($db_img)) {
        // If image contains folder path already
        if (strpos($db_img, 'uploads/profile_images/') !== false) {
            $web_path = $db_img; // web path
            $server_path = __DIR__ . '/' . $db_img; // server path
        } else {
            // Just a filename, prepend folder
            $web_path = 'uploads/profile_images/' . $db_img;
            $server_path = __DIR__ . '/uploads/profile_images/' . $db_img;
        }

        // Check if file exists on server
        if (file_exists($server_path)) {
            $profile_img = $web_path;
        }
    }
}


?>

<!-- Profile Dropdown -->
<?php if(!empty($_SESSION['user_id'])): ?>
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-light dropdown-toggle p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:50%;">
        <img src="<?= htmlspecialchars($profile_img) ?>" 
             alt="Profile" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
    </button>
    <div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 250px;">
        <div class="d-flex align-items-center mb-3">
            <img src="<?= htmlspecialchars($profile_img) ?>" 
                 alt="Profile" class="rounded-circle mr-2" style="width:50px; height:50px; object-fit:cover;">
            <div>
                <h6 class="mb-0"><?= htmlspecialchars($_SESSION['user_name']) ?></h6>
                <small class="text-muted"><?= htmlspecialchars($_SESSION['user_email']) ?></small>
                <br>
                <small class="text-primary font-weight-bold"><?= ucfirst($_SESSION['user_role']) ?></small>
            </div>
        </div>
        <div class="dropdown-divider"></div>

        <?php if($_SESSION['user_role'] === 'admin'): ?>
    <a class="dropdown-item" href="./admin/index.php">
        <i class="fas fa-tachometer-alt mr-2"></i>Go Dashboard
    </a>
<?php endif; ?>

        <a class="dropdown-item" href="profile.php"><i class="fas fa-user mr-2"></i>Profile</a>
        <a class="dropdown-item" href="wishlist.php"><i class="fas fa-heart mr-2"></i>Wishlist</a>
        <a class="dropdown-item" href="track-order.php"><i class="fas fa-truck mr-2"></i>Track Order</a>
        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
    </div>
</div>
<?php else: ?>
<a href="login.php" class="btn btn-sm btn-light">Sign In</a>
<?php endif; ?>




                    <!-- Currency -->
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">INR</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="?currency=inr">₹ INR</a>
                            <a class="dropdown-item" href="?currency=usd">$ USD</a>
                        </div>
                    </div>

                    <!-- Language Dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" id="languageBtn">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="setLanguage('en')">English</a>
                            <a class="dropdown-item" href="#" onclick="setLanguage('hi')">हिन्दी</a>
                        </div>
                    </div>

                    <!-- Google Translate Widget -->
                    <div id="google_translate_element"></div>
                </div>
                <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement(
                            {pageLanguage: 'en', includedLanguages: 'en,hi', layout: google.translate.TranslateElement.InlineLayout.SIMPLE},
                            'google_translate_element'
                        );
                    }
                    function setLanguage(lang) {
                        var gtFrame = document.querySelector('iframe.goog-te-menu-frame');
                        if (!gtFrame) {
                            googleTranslateElementInit();
                            alert('Please use the Google Translate selector at the top-right to change language.');
                            return;
                        }
                        document.getElementById('languageBtn').innerText = lang.toUpperCase();
                    }
                </script>
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

                <!-- Mobile Wishlist + Cart -->
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="wishlist.html" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="cart.html" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Second Row (Logo + Search + Contact) -->
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="index.php" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Nidra</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Homes</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="search.html" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <!-- Categories -->
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" 
                   data-toggle="collapse" href="#navbar-vertical" 
                   style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" 
                     id="navbar-vertical" 
                     style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                  <a href="comforters.php" class="nav-item nav-link">Comforters</a>
          <a href="bedsheets.php" class="nav-item nav-link">Bedsheets</a>
          <a href="dohars.php" class="nav-item nav-link">Dohars</a>
          <a href="towels.php" class="nav-item nav-link">Bath Towels</a>
          <a href="pillows.php" class="nav-item nav-link">Pillows</a>
          <a href="curtains.php" class="nav-item nav-link">Curtains</a>
          <!--<a href="new-arrivals.php" class="nav-item nav-link">New Arrivals</a>
          <a href="best-sellers.php" class="nav-item nav-link">Best Sellers</a>
          <a href="offers.php" class="nav-item nav-link">Offers & Discounts</a>-->
                    </div>
                </nav>
            </div>

            <!-- Main Navbar -->
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <!-- Mobile Logo -->
                    <a href="index.php" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Nidra</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Homes</span>
                    </a>

                    <!-- Mobile Toggle -->
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Items -->
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Shop <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                <a href="comforters.php" class="dropdown-item">Comforters</a>
                <a href="bedsheets.php" class="dropdown-item">Bedsheets</a>
                <a href="dohars.php" class="dropdown-item">Dohars</a>
                <a href="towels.php" class="dropdown-item">Bath Towels</a>
                <a href="pillows.php" class="dropdown-item">Pillows</a>
                <a href="curtains.php" class="dropdown-item">Curtains</a>
                <!--<a href="new-arrivals.php" class="dropdown-item">New Arrivals</a>
                <a href="best-sellers.php" class="dropdown-item">Best Sellers</a>
                <a href="offers.php" class="dropdown-item">Offers & Discounts</a>-->
                                </div>
                            </div>
                            <a href="about-us.php" class="nav-item nav-link">About Us</a>
                            <a href="contact-us.php" class="nav-item nav-link">Contact</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">My Account <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="login.php" class="dropdown-item">Login</a>
                                    <a href="register.php" class="dropdown-item">Register</a>
                                    <a href="wishlist.php" class="dropdown-item">Wishlist</a>
                                    <a href="track-order.php" class="dropdown-item">Track Order</a>
                                </div>
                            </div>
                        </div>
                        <?php
// Start session if not started
if (!isset($_SESSION)) {
    session_start();
}

// Include DB connection
include_once("include/db.php"); // adjust path if needed

$wishlist_count = 0;
$cart_count = 0;

// Wishlist count for logged-in user
if (!empty($_SESSION['user_id']) && isset($conn)) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($wishlist_count);
    $stmt->fetch();
    $stmt->close();
}

// Cart count stored in session
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['qty'];
    }
}
?>

<!-- Navbar Wishlist & Cart -->
<div class="navbar-nav ml-auto py-0 d-none d-lg-block">
    <a href="wishlist.php" class="btn px-0">
        <i class="fas fa-heart text-primary"></i>
        <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?= $wishlist_count ?>
        </span>
    </a>
    <a href="cart.php" class="btn px-0 ml-3">
        <i class="fas fa-shopping-cart text-primary"></i>
        <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?= $cart_count ?>
        </span>
    </a>
</div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
