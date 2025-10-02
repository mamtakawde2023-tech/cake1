<?php
session_start();
include "includes/db_connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Example cart items (replace with actual cart logic)
$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;
foreach($cart_items as $item){
    $total_price += $item['price'] * $item['quantity'];
}

$placed_order = false;
$payment_method_used = '';
$total_amount_used = 0;

if(isset($_POST['place_order'])){
    $delivery_name = $_POST['delivery_name'];
    $delivery_phone = $_POST['delivery_phone'];
    $delivery_address = $_POST['delivery_address'];
    $payment_method = $_POST['payment_method'];

    $payment_status = 'Pending';
    $payment_reference = ($payment_method == 'COD') ? NULL : 'SIMULATED123';

    $stmt = $conn->prepare("INSERT INTO orders 
        (user_id, cake_id, quantity, total_price, delivery_name, delivery_phone, delivery_address, payment_method, payment_status, payment_reference, status)
        VALUES (:user_id, :cake_id, :quantity, :total_price, :delivery_name, :delivery_phone, :delivery_address, :payment_method, :payment_status, :payment_reference, 'Pending')");

    foreach($cart_items as $item){
        $stmt->execute([
            ':user_id' => $user_id,
            ':cake_id' => $item['cake_id'],
            ':quantity' => $item['quantity'],
            ':total_price' => $item['price'] * $item['quantity'],
            ':delivery_name' => $delivery_name,
            ':delivery_phone' => $delivery_phone,
            ':delivery_address' => $delivery_address,
            ':payment_method' => $payment_method,
            ':payment_status' => $payment_status,
            ':payment_reference' => $payment_reference
        ]);
    }

    $_SESSION['cart'] = [];
    $placed_order = true;
    $payment_method_used = $payment_method;
    $total_amount_used = $total_price;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        body { font-family: Arial; background: #fff0f5; padding: 20px; }
        .checkout-container { max-width: 600px; margin: auto; }
        .cart-summary { background: #ffe6f2; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .cart-summary h3 { margin-top: 0; color: #ff1493; }
        .cart-summary table { width: 100%; border-collapse: collapse; }
        .cart-summary th, .cart-summary td { padding: 8px; border-bottom: 1px solid #ccc; text-align: left; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        input, textarea { width: 100%; padding: 10px; margin: 5px 0 15px; border-radius: 5px; border: 1px solid #ccc;}
        button { padding: 10px 20px; background: #ff69b4; color: #fff; border: none; border-radius: 5px; cursor: pointer;}
        button:hover { background: #ff1493; }
        .success { color: green; margin-bottom: 15px; text-align: center;}
        a { text-decoration: none; color: #ff1493; font-weight: bold;}
    </style>
    <script>
        function simulateRazorpay(event) {
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if(paymentMethod === 'Razorpay') {
                event.preventDefault();
                alert("🎉 Razorpay Payment Successful (Simulated)!");
                document.getElementById('checkoutForm').submit();
            }
        }
    </script>
</head>
<body>

<div class="checkout-container">

<h2>Checkout</h2>

<?php if($placed_order){ ?>
    <div class="success">
        <p>🎉 Your order has been placed successfully!</p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method_used); ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo $total_amount_used; ?></p>
        <p><a href="orders.php">View My Orders</a> | <a href="index.php">Continue Shopping</a></p>
    </div>
<?php } else { ?>

<?php if(!empty($cart_items)){ ?>
    <div class="cart-summary">
        <h3>Cart Summary</h3>
        <table>
            <tr>
                <th>Cake</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
            <?php foreach($cart_items as $item){ ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₹<?php echo $item['price'] * $item['quantity']; ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>₹<?php echo $total_price; ?></strong></td>
            </tr>
        </table>
    </div>
<?php } ?>

<form method="post" id="checkoutForm">
    <label>Delivery Name</label>
    <input type="text" name="delivery_name" required>

    <label>Phone Number</label>
    <input type="text" name="delivery_phone" required>

    <label>Address</label>
    <textarea name="delivery_address" required></textarea>

    <label>Payment Method</label><br>
    <input type="radio" name="payment_method" value="COD" checked> Cash on Delivery<br>
    <input type="radio" name="payment_method" value="Razorpay"> Razorpay (Simulated)<br><br>

    <button type="submit" name="place_order" onclick="simulateRazorpay(event)">Place Order</button>
</form>

<?php } ?>

</div>
</body>
</html>
