<?php
include "includes/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Store the message in the database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':message' => $message
    ]);

    // Send a simple automatic reply to the user
    $to = $email;
    $subject = "Thanks for contacting Cake Lovers!";
    $messageBody = "Hi $name,\n\nThank you for your message. We will get back to you soon.\n\n- Cake Lovers Team";
    $headers = "From: info@cakelovers.com";

    // Use @ to suppress errors if mail isn't configured locally
    @mail($to, $subject, $messageBody, $headers);

    // Alert user and redirect
    echo "<script>alert('Message sent successfully! Check your email for confirmation.'); window.location='index.php';</script>";

} else {
    header("Location: index.php");
    exit();
}
?>
