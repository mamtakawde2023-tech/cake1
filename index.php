<?php
session_start();
include "includes/db_connect.php";

// Dynamic links for buttons
$get_started_link = isset($_SESSION['user_id']) ? 'cakes.php' : 'login.php';
$order_link = isset($_SESSION['user_id']) ? 'cakes.php' : 'login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cake Lovers</title>
<link rel="stylesheet" href="assets/css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include "includes/header.php"; ?>

<!-- Hero Banner -->
<section class="hero-banner">
    <img src="images/banner.jpg" alt="Delicious Cakes">
    <div class="hero-text">
        <h1>Welcome to Cake Lovers</h1>
        <p>Delicious cakes made with love</p>
        <a href="<?php echo $get_started_link; ?>" class="btn-primary">Get Started</a>
    </div>
</section>

<!-- Cakes Section -->
<section class="cakes-section">
    <h2>Our Cakes</h2>
    <div class="cakes-container">
        <!-- Chocolate Cake -->
        <div class="cake-item">
            <img src="images/chocolate_cake.jpg" alt="Chocolate Cake">
            <h3>Chocolate Cake</h3>
            <p>Available in 0.5 kg, 1 kg, 2 kg</p>
            <a href="<?php echo $order_link; ?>" class="btn-secondary">Order Now</a>
        </div>

        <!-- Vanilla Cake -->
        <div class="cake-item">
            <img src="images/vanilla_cake.jpg" alt="Vanilla Cake">
            <h3>Vanilla Cake</h3>
            <p>Available in 0.5 kg, 1 kg, 2 kg</p>
            <a href="<?php echo $order_link; ?>" class="btn-secondary">Order Now</a>
        </div>

        <!-- Strawberry Cake -->
        <div class="cake-item">
            <img src="images/strawberry_cake.jpg" alt="Strawberry Cake">
            <h3>Strawberry Cake</h3>
            <p>Available in 0.5 kg, 1 kg, 2 kg</p>
            <a href="<?php echo $order_link; ?>" class="btn-secondary">Order Now</a>
        </div>
    </div>
</section>

<!-- Contact Us Section -->
<section id="contact" class="contact-section">
    <div class="contact-box">
        <h2>Contact Us</h2>
        <form action="contact_process.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</section>
