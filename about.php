<?php
session_start();
include "includes/db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<section class="about-section" style="max-width:900px; margin:30px auto; padding:20px; text-align:center;">
    <h1>About Us</h1>
    <p>Welcome to <strong>Cake Lovers</strong>! We create delicious cakes for all occasions — birthdays, weddings, anniversaries, and more.</p>
    <p>All our cakes are freshly baked using the finest ingredients and crafted with love. We also provide customization options to make your celebrations extra special.</p>
    
    <h2>Our Bakery Address</h2>
    <p>123 Sweet Street, Dessert City, 456789</p>
    <p>Email: info@cakelovers.com | Phone: +91 98765 43210</p>
    <p>Opening Hours: Mon-Sat 9:00 AM - 8:00 PM</p>
    
    <img src="images/about_us.jpg" alt="About Us" style="width:100%; max-width:500px; margin-top:20px; border-radius:10px;">
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
