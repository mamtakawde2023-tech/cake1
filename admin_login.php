<?php
session_start();
include "includes/db_connect.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email AND password = :password");
    $stmt->execute([':email'=>$email, ':password'=>$password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - Cake Lovers</title>
<link rel="stylesheet" href="assets/css/login.css">
<style>
.login-box {
    max-width: 400px;
    margin: 80px auto;
    background: #fff0f5;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
.login-box h2 {
    text-align: center;
    color: #ff1493;
}
.login-box input, .login-box button {
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.login-box button {
    background: #ff69b4;
    color: #fff;
    border: none;
    cursor: pointer;
}
.login-box button:hover {
    background: #ff1493;
}
.message { color: red; text-align: center; }
</style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
