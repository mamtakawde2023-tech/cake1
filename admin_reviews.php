<?php
session_start();
include "includes/db_connect.php";

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit;
}

// Delete review
if(isset($_GET['delete'])){
    $review_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
    $stmt->execute([':id'=>$review_id]);
}

// Fetch all reviews with user and cake details
$stmt = $conn->prepare("
    SELECT r.*, u.name AS user_name, c.name AS cake_name 
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    JOIN cakes c ON r.cake_id = c.id
    ORDER BY r.created_at DESC
");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Reviews</title>
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<?php include "includes/admin_header.php"; ?>

<h1 style="text-align:center; margin-top:20px;">Manage Reviews</h1>

<div class="admin-container">
<?php if($reviews): ?>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Cake</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($reviews as $rev): ?>
            <tr>
                <td><?php echo htmlspecialchars($rev['user_name']); ?></td>
                <td><?php echo htmlspecialchars($rev['cake_name']); ?></td>
                <td><?php echo $rev['rating']; ?> ⭐</td>
                <td><?php echo htmlspecialchars($rev['review']); ?></td>
                <td><?php echo $rev['created_at']; ?></td>
                <td>
                    <a href="admin_reviews.php?delete=<?php echo $rev['id']; ?>" class="btn-delete" onclick="return confirm('Delete this review?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align:center;">No reviews available.</p>
<?php endif; ?>
</div>

</body>
</html>
