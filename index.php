<?php
session_start();
include 'header.php';
?>
<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <!-- Main Carousel -->
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item position-relative active" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="img/Bedsheets DreamDrape Collection/11.jpeg" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Bedsheets</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                    Premium bedsheets for homes and hotels – soft, stylish, and luxurious fabrics designed for comfort and elegance.
                                </p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="bedsheets.php">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item position-relative" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="img/Comforters/7.jpeg" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Comforters</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                    Luxury comforters crafted for all-season warmth and cozy sleep, bringing elegance to every bedroom.
                                </p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="comforters.php">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item position-relative" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="img/Single Dohar two sided/3.jpeg" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Dohars & Pillows</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                    Soft, elegant dohars and pillows to complete your bedding collection – comfort and style for your home.
                                </p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="dohars.php">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Special Offers -->
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="img/Bath Towels/3.jpeg" alt="Bath Towels Offer">
                <div class="offer-text">
                    <h3 class="text-white mb-3">Bath Towels</h3>
                    <p class="text-white small">Soft and absorbent towels for daily luxury.</p>
                    <a href="towels.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="img/Curtain/2.jpeg" alt="Curtains Offer">
                <div class="offer-text">
                    <h3 class="text-white mb-3">Curtains</h3>
                    <p class="text-white small">Elegant curtains for a cozy and stylish home.</p>
                    <a href="curtains.php" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Featured Start -->
<?php include 'sections/featured.php'; ?>
<!-- Featured End -->

<!-- Categories Start -->
<?php include 'sections/categories.php'; ?>
<!-- Categories End -->

<!-- Products Start -->
<?php include 'sections/products.php'; ?>
<!-- Products End -->

<!-- Collections Start -->
<?php include 'sections/collections.php'; ?>
<!-- Collections End -->

<!-- New Arrivals Start -->
<?php include 'sections/discounts.php'; ?>
<!-- New Arrivals End -->

<?php include 'footer.php'; ?>
