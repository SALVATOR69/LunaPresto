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
    $to = "bangoola1234@gmail.com";
    $subject = "New Contact from $name";
    $body = "
        <strong>Name:</strong> $name<br>
        <strong>Email:</strong> $email<br><br>
        <strong>Message:</strong><br>
        $message
    ";

    // Headers for HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Attempt to send
    if (mail($to, $subject, $body, $headers)) {
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