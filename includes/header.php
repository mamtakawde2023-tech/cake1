<header>
    <link rel="stylesheet" href="assets/css/style.css">

    <div class="header-container">
        <a href="index.php" class="logo">
            <img src="images/logo.jpg" alt="Cake Lovers Logo" width="60">
            <h1>Cake Lovers</h1>
        </a>

        
        <?php
$currentPage = basename($_SERVER['PHP_SELF']); // get current page name
?>

<nav>
  <ul class="nav-menu">
    <li><a href="index.php" class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">Home</a></li>
    <li><a href="cakes.php" class="<?= ($currentPage == 'cakes.php') ? 'active' : '' ?>">Menu</a></li>
    <li><a href="orders.php" class="<?= ($currentPage == 'orders.php') ? 'active' : '' ?>">Orders</a></li>
   <li><a href="index.php#contact" class="<?= ($currentPage == 'index.php') ? 'active' : '' ?>">Contact</a></li>
    <li><a href="cart.php" class="<?= ($currentPage == 'cart.php') ? 'active' : '' ?>">Cart</a></li>
    <li><a href="login.php" class="<?= ($currentPage == 'login.php') ? 'active' : '' ?>">Login</a></li>
    <li><a href="about.php" class="<?= basename($_SERVER['PHP_SELF'])=='about.php'?'active':'' ?>">About</a></li>
  </ul>
</nav>

    </div>
</header>
