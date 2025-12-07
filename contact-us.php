<?php
session_start(); // Start session for login/profile functionality
include 'header.php'; // Include header (contains <head>, navbar, etc.)
?>

<!-- About Us Hero Section -->
<section class="bg-dark text-white py-5" style="background: url('img/Comforters/4.jpeg') center/cover no-repeat; background-size: cover;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-about justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Contact Us</span>
    </h2>
    <div class="row px-xl-5">
        <!-- Contact Form -->
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" id="name" placeholder="Your Name"
                            required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Your Email"
                            required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" id="subject" placeholder="Subject"
                            required="required" data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group mb-3">
                        <textarea class="form-control" rows="8" id="message" placeholder="Message"
                            required="required" data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info & Map -->
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15174.640478045025!2d74.18123239515654!3d18.040970379092325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc253666bf7152f%3A0x49d441d7463db7f7!2sLonand%2C%20Maharashtra%20415521!5e0!3m2!1sen!2sin!4v1759654816263!5m2!1sen!2sin"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                </iframe>
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>
                   Shop No. 3, Mangalmurti Empire,<br>LONAND , SATARA, MAHARASHTRA (MH), India (IN), Pin Code:- 415521
                </p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@nidrahomes.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 98765 43210</p>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<?php include 'footer.php'; // Include footer with scripts ?>
