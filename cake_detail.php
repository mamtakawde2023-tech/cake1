<?php
include "includes/db_connect.php";
session_start();

// Check login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    header("Location: cakes.php");
    exit;
}

$cake_id = intval($_GET['id']);

// Fetch cake details
$stmt = $conn->prepare("SELECT * FROM cakes WHERE id=:id");
$stmt->execute([':id'=>$cake_id]);
$cake = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$cake){
    echo "Cake not found!";
    exit;
}

// Handle customization form submission (Add to Cart)
$message = '';
if(isset($_POST['add_to_cart'])){

    $size = $_POST['size'];
    $flavour = $_POST['flavour'];
    $toppings = $_POST['toppings'];
    $personal_message = $_POST['message'];

    // Extra charges for size
    $extra_charges = 0;
    if($size == "2kg"){
        $extra_charges += 300; // ₹300 extra for large size
    }
    $extra_charges += floatval($_POST['extra_charges']); // Additional user extra charges

    // Handle image upload
    $image_name = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "images/uploads/".$image_name);
    }

    // Insert customization
    $stmt = $conn->prepare("INSERT INTO cake_customizations 
        (cake_id, size, flavour, toppings, message, image, extra_charges)
        VALUES (:cake_id, :size, :flavour, :toppings, :message, :image, :extra_charges)");
    $stmt->execute([
        ':cake_id'=>$cake_id,
        ':size'=>$size,
        ':flavour'=>$flavour,
        ':toppings'=>$toppings,
        ':message'=>$personal_message,
        ':image'=>$image_name,
        ':extra_charges'=>$extra_charges
    ]);

    $customization_id = $conn->lastInsertId();

    // Add to cart
    $stmt = $conn->prepare("INSERT INTO cart (user_id, cake_id, customization_id, quantity) VALUES (:user, :cake, :custom, 1)");
    $stmt->execute([
        ':user'=>$user_id,
        ':cake'=>$cake_id,
        ':custom'=>$customization_id
    ]);

    $message = "Added to cart successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($cake['name']); ?> - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/cake_detail.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<div class="cake-detail-container">
    <h1><?php echo htmlspecialchars($cake['name']); ?></h1>
    <img src="images/<?php echo htmlspecialchars($cake['image']); ?>" alt="<?php echo htmlspecialchars($cake['name']); ?>" class="cake-image">
    <p>Base Price: ₹<?php echo htmlspecialchars($cake['price']); ?></p>
    <p>Rating: <?php echo ($cake['rating_count']>0)?round($cake['rating'],1)." ⭐":"Not rated yet"; ?></p>

    <?php if($message) echo "<p class='message'>$message</p>"; ?>

    <form method="POST" enctype="multipart/form-data" class="customization-form">
        <h3>Customize Your Cake</h3>

        <label>Size:</label>
        <select name="size" required>
            <option value="0.5kg">0.5 kg (+₹0)</option>
            <option value="1kg">1 kg (+₹50)</option>
            <option value="2kg">2 kg (+₹300)</option>
        </select>

        <label>Flavour:</label>
        <select name="flavour" required>
            <option value="Chocolate">Chocolate (+₹50)</option>
            <option value="Vanilla">Vanilla (+₹30)</option>
            <option value="Strawberry">Strawberry (+₹40)</option>
        </select>

        <label>Extra Toppings:</label>
        <input type="text" name="toppings" placeholder="Ex: Nuts, Choco chips (+₹20 each)">

        <label>Personal Message:</label>
        <input type="text" name="message" placeholder="Message on cake">

        <label>Upload Suggestion Image:</label>
        <input type="file" name="image" accept="image/*">

        <label>Extra Charges (₹):</label>
        <input type="number" name="extra_charges" value="0" step="1">

        <button type="submit" name="add_to_cart" class="btn-order">Add to Cart</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
