<?php
session_start();
include "includes/db_connect.php";

$user_id = $_SESSION['user_id'] ?? 0;
if(!$user_id){
    header("Location: login.php");
    exit;
}

// Remove item
if(isset($_GET['remove'])){
    $remove_id = intval($_GET['remove']);
    $stmt = $conn->prepare("DELETE FROM cart WHERE id=:id AND user_id=:user");
    $stmt->execute([':id'=>$remove_id, ':user'=>$user_id]);
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, cakes.*, cart.size, cart.flavour, cart.message_text, cart.toppings, cart.extra_charges, cart.quantity
    FROM cart
    JOIN cakes ON cakes.id = cart.cake_id
    WHERE cart.user_id=:user
");
$stmt->execute([':user'=>$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total_price = 0;
foreach($cart_items as $item){
    $total_price += ($item['price'] + $item['extra_charges']) * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Your Cart - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<h1 style="text-align:center; margin-top:20px;">Your Cart</h1>

<?php if(count($cart_items) > 0): ?>
<div class="cart-container">
<table class="cart-table">
    <tr>
        <th>Cake</th>
        <th>Customization</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>
    <?php foreach($cart_items as $item): ?>
    <tr>
        <td><?php echo htmlspecialchars($item['name']); ?><br>
            <img src="images/<?php echo $item['image']; ?>" width="50">
        </td>
        <td style="text-align:left;">
            Size: <?php echo $item['size']; ?><br>
            Flavour: <?php echo $item['flavour'] ?: '-'; ?><br>
            Toppings: <?php echo $item['toppings'] ?: '-'; ?><br>
            Message: <?php echo $item['message_text'] ?: '-'; ?><br>
            Extra Charges: ₹<?php echo $item['extra_charges']; ?>
        </td>
        <td>₹<?php echo $item['price']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>₹<?php echo ($item['price'] + $item['extra_charges']) * $item['quantity']; ?></td>
        <td><a href="cart.php?remove=<?php echo $item['cart_id']; ?>" class="btn-remove">Remove</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</div>

<h3 style="text-align:center;">Total Price: ₹<?php echo $total_price; ?></h3>
<div style="text-align:center; margin:20px;">
    <a href="checkout.php" class="btn-order">Proceed to Checkout</a>
</div>

<?php else: ?>
<p style="text-align:center;">Your cart is empty.</p>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
</body>
</html>
