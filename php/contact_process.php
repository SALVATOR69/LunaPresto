<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Validate form inputs
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['message' => 'Please complete the form correctly and try again.']);
        exit;
    }

    // Setup email
    $to = "lunaamig@lunapresto.com";
    $subject = "New Contact from $name";
    $body = "
        <strong>Name:</strong> $name<br>
        <strong>Email:</strong> $email<br><br>
        <strong>Message:</strong><br>
        $message
    ";

    // SMTP email headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: no-reply@lunapresto.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    // Additional parameters to enforce envelope sender
    $params = "-fno-reply@lunapresto.com";

    // Attempt to send
    if (mail($to, $subject, $body, $headers, $params)) {
        http_response_code(200);
        echo json_encode(['message' => 'Message sent successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to send message. Please try again later.']);
    }
} else {
    http_response_code(403);
    echo json_encode(['message' => 'Invalid request method.']);
}
?>