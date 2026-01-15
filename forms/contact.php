<?php
  /**
  * Contact Form Handler
  * Sends form submissions to your personal email: aloke8459@gmail.com
  */

  // Get form data
  $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
  $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
  $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
  $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

  // Validation
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
  }

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
  }

  // Your personal email address
  $recipient_email = 'aloke8459@gmail.com';

  // Email headers
  $headers = "From: " . $email . "\r\n";
  $headers .= "Reply-To: " . $email . "\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

  // Email body
  $email_body = "
    <html>
      <body>
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> " . $name . "</p>
        <p><strong>Email:</strong> " . $email . "</p>
        <p><strong>Subject:</strong> " . $subject . "</p>
        <p><strong>Message:</strong></p>
        <p>" . nl2br($message) . "</p>
      </body>
    </html>
  ";

  // Send email
  if (mail($recipient_email, "New Contact: " . $subject, $email_body, $headers)) {
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully']);
  } else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to send message. Please try again.']);
  }
?>
