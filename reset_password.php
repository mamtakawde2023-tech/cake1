<?php
session_start();
include "includes/db_connect.php";

$message = '';

if (isset($_POST['reset'])) {
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    // Find valid token
    $stmt = $conn->prepare("SELECT pr.user_id FROM password_resets pr 
                            JOIN users u ON pr.user_id = u.id
                            WHERE pr.token = :token AND pr.expires_at > NOW()
                            ORDER BY pr.id DESC LIMIT 1");
    $stmt->execute([':token' => $token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset) {
        // Update password (plain text as you asked earlier, can switch back to hash later)
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $new_password,
            ':id' => $reset['user_id']
        ]);

        // Delete used tokens
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = :id");
        $stmt->execute([':id' => $reset['user_id']]);

        $message = "Password reset successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Invalid or expired token!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<?php include "includes/header.php"; ?>
<div class="login-box">
    <h2>Reset Password</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="token" placeholder="Enter your token" required>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
