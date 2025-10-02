<?php
session_start();
include "includes/db_connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for this customer
$stmt = $conn->prepare("
    SELECT o.*, c.name AS cake_name, c.image AS cake_image
    FROM orders o
    JOIN cakes c ON o.cake_id = c.id
    WHERE o.user_id = :user_id
    ORDER BY o.created_at DESC
");
$stmt->execute([':user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders - Cake Lovers</title>
    <link rel="stylesheet" href="assets/css/cart.css">
    <style>
        .orders-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #fff0f5;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #ff69b4; color: #fff; }
        .status { padding: 5px 10px; border-radius: 5px; font-weight: bold; }
        .Pending { background-color: #ffeeba; }
        .Delivered { background-color: #d4edda; }
        .Cancelled { background-color: #f8d7da; }
        img.cake-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
<?php include "includes/header.php"; ?>

<div class="orders-container">
<h2>My Orders</h2>

<?php if(empty($orders)) { ?>
    <p>You have not placed any orders yet. <a href="cakes.php">Shop Now</a></p>
<?php } else { ?>
    <table>
        <tr>
            <th>Order No</th>
            <th>Cake</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Flavour</th>
            <th>Toppings</th>
            <th>Message</th>
            <th>Extra Charges</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Delivery Status</th>
            <th>Order Date</th>
        </tr>
        <?php foreach($orders as $order) { ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['cake_name']); ?></td>
            <td><img src="images/<?php echo $order['cake_image']; ?>" class="cake-img"></td>
            <td><?php echo $order['quantity']; ?></td>
            <td><?php echo $order['size']; ?> kg</td>
            <td><?php echo htmlspecialchars($order['flavour']); ?></td>
            <td><?php echo htmlspecialchars($order['toppings']); ?></td>
            <td><?php echo htmlspecialchars($order['message']); ?></td>
            <td>₹<?php echo $order['extra_charges']; ?></td>
            <td>₹<?php echo ($order['total_price'] + $order['extra_charges']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
            <td class="status <?php echo $order['status']; ?>"><?php echo $order['status']; ?></td>
            <td><?php echo $order['created_at']; ?></td>
        </tr>
        <?php } ?>
    </table>
<?php } ?>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
