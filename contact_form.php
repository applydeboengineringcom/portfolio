<?php
// contact_form.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Enable verbose debugging
        $mail->SMTPDebug = 2; // 2 = Enable verbose debug output

        // Server settings
        $mail->isSMTP(); // Use SMTP
        $mail->Host = 'smtp.gmail.com'; // SMTP server (e.g., Gmail)
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'abrehamabreham43@gmail.com'; // Your Gmail address
        $mail->Password = ''; // Your Gmail password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress('abrehamabreham43@gmail.com'); // Recipient's email

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = $subject;
        $mail->Body = "You have received a new message from the contact form on your website.\n\n" .
                      "Here are the details:\n" .
                      "Name: $name\n" .
                      "Email: $email\n" .
                      "Subject: $subject\n" .
                      "Message:\n$message\n";

        // Send the email
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send message. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>