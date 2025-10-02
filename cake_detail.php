<?php
session_start();
include "includes/db_connect.php";

$cake_id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM cakes WHERE id = :id");
$stmt->execute([':id' => $cake_id]);
$cake = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$cake){
    echo "Cake not found!";
    exit;
}

if(isset($_POST['add_to_cart'])){
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }

    $size = $_POST['size'];
    $flavour = $_POST['flavour'];
    $message_text = $_POST['message'] ?? '';
    $toppings = $_POST['toppings'];
    $quantity = intval($_POST['quantity'] ?? 1);

    // Extra charges calculation
    $extra_charges = 0;
    if($size == '0.5kg') $extra_charges -= 200; // smaller
    if($size == '2kg') $extra_charges += 350; // bigger
    if($flavour != '') $extra_charges += 100;
    if($message_text != '') $extra_charges += 10;
    if($toppings != '') $extra_charges += 50;

    $stmt = $conn->prepare("INSERT INTO cart (cake_id, size, flavour, message_text, toppings, extra_charges, quantity, user_id) 
                            VALUES (:cake_id, :size, :flavour, :message_text, :toppings, :extra_charges, :quantity, :user_id)");
    $stmt->execute([
        ':cake_id' => $cake_id,
        ':size' => $size,
        ':flavour' => $flavour,
        ':message_text' => $message_text,
        ':toppings' => $toppings,
        ':extra_charges' => $extra_charges,
        ':quantity' => $quantity,
        ':user_id' => $_SESSION['user_id']
    ]);

    echo "<script>alert('Added to cart!'); window.location='cart.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($cake['name']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<div class="cake-detail-container" style="max-width:600px; margin:30px auto; background:#fff0f5; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
    <h2><?php echo htmlspecialchars($cake['name']); ?></h2>
    <img src="images/<?php echo $cake['image']; ?>" width="300" style="display:block; margin:10px auto;">
    <p><?php echo htmlspecialchars($cake['description']); ?></p>
    <p>Base Price (0.5kg): ₹<?php echo $cake['price']; ?></p>

    <form method="POST">
        <label>Size:</label><br>
        <select name="size" required>
            <option value="0.5kg">0.5kg (-200 ₹)</option>
            <option value="1kg" selected>1kg (Base Price)</option>
            <option value="2kg">2kg (+350 ₹)</option>
        </select><br><br>

        <label>Flavour (100 ₹):</label><br>
        <input type="text" name="flavour" placeholder="Enter flavour"><br><br>

        <label>Message (10 ₹):</label><br>
        <input type="text" name="message" placeholder="Enter message"><br><br>

        <label>Toppings (50 ₹):</label><br>
        <input type="text" name="toppings" placeholder="Enter toppings"><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="1" min="1"><br><br>

        <button type="submit" name="add_to_cart" class="btn-order">Add to Cart</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
