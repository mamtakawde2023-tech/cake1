<?php
session_start();
include "includes/db_connect.php";

// Admin authentication
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit;
}

// Update order status
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=:status WHERE id=:id");
    $stmt->execute([':status'=>$new_status, ':id'=>$order_id]);
}

// Fetch all orders
$stmt = $conn->prepare("
    SELECT o.*, c.name AS cake_name, c.image AS cake_image
    FROM orders o
    JOIN cakes c ON o.cake_id = c.id
    ORDER BY o.created_at DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch cake stock
$stmt2 = $conn->prepare("SELECT id, name, stock FROM cakes");
$stmt2->execute();
$cakes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Cake Lovers</title>
    <style>
        body { font-family: Arial; background: #fff0f5; padding: 20px;}
        h2 { text-align:center; color:#ff1493;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center;}
        th { background: #ff69b4; color:#fff; }
        select, button { padding:5px 10px; margin:2px; }
        .cake-img { width: 50px; height:50px; object-fit:cover; border-radius:5px;}
        .status { font-weight:bold; padding:5px 10px; border-radius:5px; }
        .pending { background:#ffeeba; }
        .confirmed { background:#d1ecf1; }
        .out { background:#cce5ff; }
        .delivered { background:#d4edda; }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>

<h3>Orders</h3>
<table>
    <tr>
        <th>Order ID</th>
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
        <th>Status</th>
        <th>Delivery Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php foreach($orders as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= htmlspecialchars($order['cake_name']) ?></td>
        <td><img src="images/<?= $order['cake_image'] ?>" class="cake-img"></td>
        <td><?= $order['quantity'] ?></td>
        <td><?= $order['size'] ?></td>
        <td><?= $order['flavour'] ?></td>
        <td><?= $order['toppings'] ?></td>
        <td><?= $order['message'] ?></td>
        <td>₹<?= $order['extra_charges'] ?></td>
        <td>₹<?= $order['total_price'] ?></td>
        <td><?= $order['payment_method'] ?></td>
        <td class="status <?= strtolower(str_replace(' ', '', $order['status'])) ?>"><?= $order['status'] ?></td>
        <td><?= htmlspecialchars($order['delivery_name']) ?></td>
        <td><?= htmlspecialchars($order['delivery_phone']) ?></td>
        <td><?= htmlspecialchars($order['delivery_address']) ?></td>
        <td><?= $order['created_at'] ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <select name="status">
                    <option value="Pending" <?= $order['status']=='Pending'?'selected':'' ?>>Pending</option>
                    <option value="Confirmed" <?= $order['status']=='Confirmed'?'selected':'' ?>>Confirmed</option>
                    <option value="Out for Delivery" <?= $order['status']=='Out for Delivery'?'selected':'' ?>>Out for Delivery</option>
                    <option value="Delivered" <?= $order['status']=='Delivered'?'selected':'' ?>>Delivered</option>
                </select>
                <button type="submit" name="update_status">Update</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Cake Stock</h3>
<table>
    <tr>
        <th>Cake ID</th>
        <th>Cake Name</th>
        <th>Stock</th>
    </tr>
    <?php foreach($cakes as $cake): ?>
    <tr>
        <td><?= $cake['id'] ?></td>
        <td><?= htmlspecialchars($cake['name']) ?></td>
        <td><?= $cake['stock'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
