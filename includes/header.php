<?php
if(session_status() == PHP_SESSION_NONE) session_start();
include "db_connect.php";

// Count items in cart
$cart_count = 0;
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $item){
        $cart_count += $item['quantity'];
    }
}

$currentPage = basename($_SERVER['PHP_SELF']);
$user_logged_in = isset($_SESSION['user_id']);
?>

<header>
    <link rel="stylesheet" href="assets/css/style.css">

    <div class="header-container">
        <a href="index.php" class="logo">
            <img src="images/logo.jpg" alt="Cake Lovers Logo" width="60">
            <h1>Cake Lovers</h1>
        </a>

        <nav>
            <ul class="nav-menu">
                <li><a href="index.php" class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">Home</a></li>
                <li><a href="cakes.php" class="<?= ($currentPage == 'cakes.php') ? 'active' : '' ?>">Menu</a></li>
                <?php if($user_logged_in): ?>
                    <li><a href="orders.php" class="<?= ($currentPage == 'orders.php') ? 'active' : '' ?>">Orders</a></li>
                <?php endif; ?>
                <li><a href="index.php#contact" class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">Contact</a></li>
                <li>
                    <a href="cart.php" class="<?= ($currentPage == 'cart.php') ? 'active' : '' ?>">
                        Cart <?php if($cart_count>0) echo "($cart_count)"; ?>
                    </a>
                </li>
                <?php if($user_logged_in): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="<?= ($currentPage == 'login.php') ? 'active' : '' ?>">Login</a></li>
                    <li><a href="register.php" class="<?= ($currentPage == 'register.php') ? 'active' : '' ?>">Register</a></li>
                <?php endif; ?>
                <li><a href="about.php" class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">About</a></li>
            </ul>
        </nav>
    </div>
</header>
