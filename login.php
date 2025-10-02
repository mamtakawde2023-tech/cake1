<?php
session_start();
include "includes/db_connect.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->execute([':email' => $email, ':password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Incorrect email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<section class="login-section">
    <div class="login-box">
        <h2>Login</h2>
        <?php if($error) echo "<p class='message'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </div>
</section>

<?php include "includes/footer.php"; ?>
</body>
</html>
