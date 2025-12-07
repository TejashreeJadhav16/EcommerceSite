<?php
session_start(); // Start session for user login info
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>About - Nidra Homes</title>
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
        .product-img { width: 100%; height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #fff; }
        .product-img img { height: 100%; width: auto; object-fit: cover; }
        .breadcrumb-about { background-color: transparent; }
        .breadcrumb-about .breadcrumb-item a { color: #FFD700; font-weight: 500; }
        .breadcrumb-about .breadcrumb-item a:hover { color: #FFA500; }
        .breadcrumb-about .breadcrumb-item.active { color: #000; font-weight: 600; }
        .hover-shadow:hover { transform: translateY(-5px); transition: 0.3s ease-in-out; box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
    </style>
</head>

<body>
<!-- Header Start -->
<?php include 'header.php'; ?>
<!-- Header End -->

<!-- About Us Hero Section -->
<section class="bg-dark text-white py-5" style="background: url('img/Comforters/8.jpeg') center/cover no-repeat; background-size: cover;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-about justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</section>

<!-- About Us Section -->
<section id="about-us" class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="img/Nidra Homes.png" alt="Nidra Homes" class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title position-relative text-uppercase mb-4">
                    <span class="px-3 py-1 rounded fw-bold" style="color:#000;">About Us – NIDRA HOMES</span>
                </h2>
                <p class="lead text-muted mb-4">
                    <strong class="text-dark">Welcome to NIDRA HOMES – Where Comfort Meets Elegance.</strong><br>
                    We specialize in <strong>luxury linens</strong> for homes and hotels. 
                    From <strong>soft, stylish bedding</strong> 
                    to <strong>durable, high-performance linens</strong>, 
                    we bring <strong>comfort, elegance, and quality</strong> to every setting.
                </p>

                <div class="row g-3">
                    <?php
                    $products = [
                        ['img' => 'img/Comforters/1.jpeg', 'title' => 'Comforters', 'desc' => 'Aurora Collection'],
                        ['img' => 'img/Bedsheets DreamDrape Collection/10.jpeg', 'title' => 'Bedsheets', 'desc' => 'Moon Thread Collection'],
                        ['img' => 'img/Single Dohar two sided/2.jpeg', 'title' => 'Dohars', 'desc' => 'Sukoon & Nestle'],
                        ['img' => 'img/Bath Towels/4.jpeg', 'title' => 'Towels', 'desc' => 'Woven Bliss Collection'],
                        ['img' => 'img/Pillow/1.jpeg', 'title' => 'Pillows', 'desc' => 'PlushNest & SnugRest'],
                        ['img' => 'img/Curtain/1.jpeg', 'title' => 'Curtains', 'desc' => 'Dark Serenity Blackout']
                    ];
                    foreach($products as $p): ?>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 border rounded shadow-sm hover-shadow">
                                <img src="<?= $p['img'] ?>" alt="<?= $p['title'] ?>" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover; margin-right:15px;">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark"><?= $p['title'] ?></h6>
                                    <small class="text-muted"><?= $p['desc'] ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 p-3 bg-light rounded shadow-sm text-center">
                    <p class="mb-1 fw-bold text-dark">For Homes | For Hotels | Luxury Fabrics | Perfect for Gifting</p>
                    <p class="mb-0 fw-bold fs-5" style="color:#000;">
                        Discover the <span class="fw-bold">Art of Rest</span> – Only at <span class="fw-bold">NIDRA HOMES</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

