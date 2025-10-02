<?php
session_start();
include "includes/db_connect.php";

$message = '';

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email'=>$email]);
    if($stmt->rowCount() > 0){
        $message = "Email already registered! Try logging in.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
        if($stmt->execute([':name'=>$name, ':email'=>$email, ':password'=>$password])){
            $message = "Registration successful! You can now login.";
        } else {
            $message = "Registration failed! Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<section class="register-section">
    <div class="register-box">
        <h2>Register</h2>
        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
