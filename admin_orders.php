<?php
session_start();
include "includes/db_connect.php";

// Fetch all orders with user name
$stmt = $conn->query("SELECT o.*, u.name AS username, c.name AS cake_name 
                      FROM orders o 
                      JOIN users u ON o.user_id = u.id 
                      JOIN cakes c ON o.cake_id = c.id 
                      ORDER BY o.created_at DESC");

// Handle status update
if(isset($_POST['order_id'], $_POST['new_status'])){
    $update = $conn->prepare("UPDATE orders SET status = :status, status_updated_at = NOW() WHERE id = :id");
    $update->execute([
        ':status' => $_POST['new_status'],
        ':id' => $_POST['order_id']
    ]);
    header("Location: admin_orders.php");
    exit;
}

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #fff0f5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center;}
        th { background: #ff69b4; color: #fff;}
        .cod { background-color: #d4edda; }
        .razorpay { background-color: #cce5ff; }
        select { padding: 5px; border-radius: 5px; }
    </style>
</head>
<body>

<h2>Admin Orders Panel</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>User</th>
        <th>Cake</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Delivery Name</th>
        <th>Phone</th>
        <th>Address</th>
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
        <td><?php echo htmlspecialchars($order['username']); ?></td>
        <td><?php echo htmlspecialchars($order['cake_name']); ?></td>
        <td><?php echo $order['quantity']; ?></td>
        <td>₹<?php echo $order['total_price']; ?></td>
        <td><?php echo htmlspecialchars($order['delivery_name']); ?></td>
        <td><?php echo htmlspecialchars($order['delivery_phone']); ?></td>
        <td><?php echo htmlspecialchars($order['delivery_address']); ?></td>
        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
        <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
        <td>
            <form method="post" style="margin:0;">
                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                <select name="new_status" onchange="this.form.submit()">
                    <option value="Pending" <?php if($order['status']=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Delivered" <?php if($order['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Cancelled" <?php if($order['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </form>
        </td>
        <td><?php echo $order['created_at']; ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
