<?php 
include "includes/db_connect.php";
session_start();

// Handle search
$search = '';
if(isset($_GET['search'])){
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM cakes WHERE name LIKE :search");
    $stmt->execute([':search' => "%$search%"]);
} else {
    $stmt = $conn->prepare("SELECT * FROM cakes");
    $stmt->execute();
}
$cakes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Cakes - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/cakes.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<h1 style="text-align:center; margin-top:20px;">Our Cakes</h1>

<!-- Search Form -->
<div class="search-container" style="text-align:center; margin:20px;">
    <form method="GET" action="cakes.php">
        <input type="text" name="search" placeholder="Search cakes..." value="<?php echo htmlspecialchars($search); ?>" required>
        <button type="submit">Search</button>
    </form>
</div>

<div class="cakes-container">
<?php
if($cakes){
    foreach($cakes as $cake){
        echo '<div class="cake-item">';
        echo '<img src="images/' . htmlspecialchars($cake['image']) . '" alt="' . htmlspecialchars($cake['name']) . '">';
        echo '<h3>' . htmlspecialchars($cake['name']) . '</h3>';
        echo '<p>Price: ₹' . htmlspecialchars($cake['price']) . '</p>';

        // Show overall rating only
        $rating_text = ($cake['rating_count'] > 0) ? round($cake['rating'],1) . " ⭐" : "Not rated yet";
        echo '<p>Rating: ' . $rating_text . '</p>';

        // Check if user is logged in
        if(isset($_SESSION['user_id'])){
            // Direct to customization page
            echo '<a href="cake_detail.php?id=' . $cake['id'] . '" class="btn-order">Order Now</a> ';
        } else {
            echo '<a href="login.php" class="btn-order">Order Now</a>';
        }

        // View Details button
        echo '<a href="cake_detail.php?id=' . $cake['id'] . '" class="btn-detail">View Details</a>';

        echo '</div>';
    }
} else {
    echo "<p style='text-align:center;'>No cakes found.</p>";
}
?>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
