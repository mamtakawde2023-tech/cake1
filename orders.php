<?php
session_start();
include "includes/db_connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT o.*, c.name AS cake_name 
                        FROM orders o 
                        JOIN cakes c ON o.cake_id = c.id 
                        WHERE o.user_id = :user_id 
                        ORDER BY o.created_at DESC");
$stmt->execute([':user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body { font-family: Arial; background: #fff0f5; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center;}
        th { background: #ff69b4; color: #fff;}
        .cod { background-color: #d4edda; }
        .razorpay { background-color: #cce5ff; }
        .status { font-weight: bold; padding: 5px 10px; border-radius: 5px; }
    </style>
</head>
<body>

<h2>My Orders</h2>

<?php if(empty($orders)){ ?>
    <p>You have not placed any orders yet. <a href="index.php">Shop Now</a></p>
<?php } else { ?>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Cake</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Created At</th>
        </tr>
        <?php foreach($orders as $order){ 
            $row_class = ($order['payment_method'] == 'COD') ? 'cod' : 'razorpay';
        ?>
        <tr class="<?php echo $row_class; ?>">
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['cake_name']); ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td>₹<?php echo $order['total_price']; ?></td>
            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
            <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
            <td><?php echo htmlspecialchars($order['status']); ?></td>
            <td><?php echo $order['created_at']; ?></td>
        </tr>
        <?php } ?>
    </table>
<?php } ?>

</body>
</html>
