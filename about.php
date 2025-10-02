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

<section class="about-section" style="max-width:900px; margin:30px auto; padding:30px; text-align:center; background:#fff0f5; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1);">
    <h1 style="color:#ff69b4; margin-bottom:20px;">About Cake Lovers</h1>
    
    <p>Welcome to <strong>Cake Lovers</strong>! We craft <span style="color:#ff1493;">delicious cakes</span> for all your special occasions — birthdays, weddings, anniversaries, and more.</p>
    
    <p>Every cake is freshly baked using the finest ingredients and designed with love. We offer <strong>customization options</strong> so you can make your celebration truly unforgettable.</p>
    
    <h2 style="color:#ff69b4; margin-top:30px;">Our Bakery</h2>
    <p>123 Sweet Street, Dessert City, 456789</p>
    <p>Email: <strong>info@cakelovers.com</strong> | Phone: <strong>+91 98765 43210</strong></p>
    <p>Opening Hours: Mon-Sat 9:00 AM - 8:00 PM</p>
    
    <p style="margin-top:20px; font-style:italic; color:#555;">“Bringing joy, one slice at a time!”</p>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
