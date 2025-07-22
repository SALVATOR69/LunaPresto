<?php
header('Content-Type: application/json');

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic validation
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['message' => 'Invalid input. Please complete the form properly.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.lunapresto.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@lunapresto.com';
        $mail->Password   = '4xQaf1RESpQK';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Sender and recipient
        $mail->setFrom('contact@lunapresto.com', 'Lunapresto');
        $mail->addAddress($email, $name);
        $mail->addReplyTo($email, $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Message to Lunapresto';
        $mail->Body    = "
            <html>
            <body>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
            </body>
            </html>
        ";

        $mail->send();
        echo json_encode(['message' => 'Message sent successfully.']);
    } catch (Exception $e) {
        echo json_encode(['message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    header('Location: /links/contact.html');
    exit;
}