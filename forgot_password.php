<?php
session_start();
include "includes/db_connect.php";

$message = '';

if(isset($_POST['forgot'])){
    $email = trim($_POST['email']);

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        // Generate a new password
        $new_password = substr(md5(rand()), 0, 8); // 8-character random password

        // Update in DB (plain text)
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([':password' => $new_password, ':id' => $user['id']]);

        $message = "Your new password is: <b>$new_password</b><br>Use it to login immediately.";
    } else {
        $message = "No account found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<?php include "includes/header.php"; ?>

<section class="login-section">
    <div class="login-box">
        <h2>Forgot Password</h2>
        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="forgot">Generate New Password</button>
        </form>
        <p>Back to <a href="login.php">Login</a></p>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
