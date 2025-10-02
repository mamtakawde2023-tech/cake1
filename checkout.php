<?php
session_start();
include "includes/db_connect.php";

$user_id = $_SESSION['user_id'] ?? 0;
if(!$user_id){
    header("Location: login.php");
    exit;
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, cakes.id AS cake_id, cakes.name, cakes.image, cakes.price, cart.size, cart.flavour, cart.message_text, cart.toppings, cart.extra_charges, cart.quantity
    FROM cart
    JOIN cakes ON cakes.id = cart.cake_id
    WHERE cart.user_id=:user
");
$stmt->execute([':user'=>$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!$cart_items){
    echo "<script>alert('Your cart is empty!'); window.location='index.php';</script>";
    exit;
}

// Calculate total
$total_price = 0;
foreach($cart_items as $item){
    $total_price += ($item['price'] + $item['extra_charges']) * $item['quantity'];
}

$message = '';
if(isset($_POST['place_order'])){
    $delivery_name = trim($_POST['delivery_name']);
    $delivery_phone = trim($_POST['delivery_phone']);
    $delivery_address = trim($_POST['delivery_address']);
    $payment_method = $_POST['payment_method'] ?? 'COD';

    foreach($cart_items as $item){
        $stmt = $conn->prepare("
            INSERT INTO orders 
            (user_id, cake_id, quantity, total_price, delivery_name, delivery_phone, delivery_address, payment_method, status, size, flavour, message, toppings, extra_charges)
            VALUES
            (:user_id, :cake_id, :quantity, :total_price, :delivery_name, :delivery_phone, :delivery_address, :payment_method, 'Pending', :size, :flavour, :message, :toppings, :extra_charges)
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':cake_id' => $item['cake_id'],
            ':quantity' => $item['quantity'],
            ':total_price' => ($item['price'] + $item['extra_charges']) * $item['quantity'],
            ':delivery_name' => $delivery_name,
            ':delivery_phone' => $delivery_phone,
            ':delivery_address' => $delivery_address,
            ':payment_method' => $payment_method,
            ':size' => $item['size'],
            ':flavour' => $item['flavour'],
            ':message' => $item['message_text'],
            ':toppings' => $item['toppings'],
            ':extra_charges' => $item['extra_charges']
        ]);
    }

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user");
    $stmt->execute([':user'=>$user_id]);

    $message = "🎉 Your order has been placed successfully! Total Amount: ₹$total_price. Payment Method: $payment_method";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Cake Lovers</title>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<div class="cart-container" style="max-width:700px; margin:30px auto; padding:20px; background:#fff0f5; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align:center;">Checkout</h2>

    <?php if($message): ?>
        <p style="color:green; text-align:center; font-weight:bold;"><?php echo $message; ?></p>
        <p style="text-align:center;"><a href="orders.php">View My Orders</a> | <a href="index.php">Continue Shopping</a></p>
    <?php else: ?>
        <form method="POST">
            <label>Delivery Name:</label><br>
            <input type="text" name="delivery_name" placeholder="Full Name" required style="width:100%; padding:10px; margin-bottom:10px;"><br>

            <label>Phone:</label><br>
            <input type="text" name="delivery_phone" placeholder="Phone Number" required style="width:100%; padding:10px; margin-bottom:10px;"><br>

            <label>Delivery Address:</label><br>
            <textarea name="delivery_address" placeholder="House No, Locality, City, State, Pincode" required style="width:100%; padding:10px; margin-bottom:10px;" rows="5"></textarea><br>

            <label>Payment Method:</label><br>
            <select name="payment_method" style="width:100%; padding:10px; margin-bottom:20px;">
                <option value="COD">Cash on Delivery</option>
                <option value="GPay">GPay / UPI</option>
            </select>

            <h3>Total Amount: ₹<?php echo $total_price; ?></h3>
            <div style="text-align:center; margin-top:20px;">
                <button type="submit" name="place_order" class="btn-order">Place Order</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
