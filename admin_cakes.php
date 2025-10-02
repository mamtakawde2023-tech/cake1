<?php
session_start();
include "../includes/db_connect.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Add new cake
if (isset($_POST['add_cake'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $stmt = $conn->prepare("INSERT INTO cakes (name, description, price, stock) VALUES (:name, :description, :price, :stock)");
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':stock' => $stock
    ]);
}

// Delete cake
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM cakes WHERE id = :id");
    $stmt->execute([':id' => $delete_id]);
}

// Fetch cakes
$stmt = $conn->prepare("SELECT * FROM cakes ORDER BY id DESC");
$stmt->execute();
$cakes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Cakes - Admin Panel</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include "admin_header.php"; ?>

<div class="admin-container">
    <h1>Manage Cakes</h1>

    <h2>Add New Cake</h2>
    <form method="POST" class="admin-form">
        <input type="text" name="name" placeholder="Cake Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit" name="add_cake">Add Cake</button>
    </form>

    <h2>All Cakes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cakes as $cake): ?>
            <tr>
                <td><?= $cake['id'] ?></td>
                <td><?= htmlspecialchars($cake['name']) ?></td>
                <td><?= htmlspecialchars($cake['description']) ?></td>
                <td>₹<?= number_format($cake['price'], 2) ?></td>
                <td><?= $cake['stock'] ?></td>
                <td>
                    <a href="admin_cakes.php?delete=<?= $cake['id'] ?>" onclick="return confirm('Delete this cake?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
