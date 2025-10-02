<?php
session_start();
include "includes/db_connect.php";

$message = '';

if(isset($_POST['set_password'])){
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($new_password !== $confirm_password){
        $message = "Passwords do not match!";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->execute([':password' => $new_password, ':id' => $user['id']]);
            $message = "Password updated successfully! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Email not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set New Password - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<section class="login-section">
    <div class="login-box">
        <h2>Set New Password</h2>
        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="set_password">Set Password</button>
        </form>
        <p>Back to <a href="login.php">Login</a></p>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
