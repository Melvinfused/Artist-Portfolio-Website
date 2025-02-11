<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Check if all fields are filled
    if ($name && $email && $subject && $message) {
        // Your email address
        $to = "thomasfrancymoothedath0@gmail.com";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // Email subject and body
        $email_subject = "New Contact Form Submission: $subject";
        $email_body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

        // Send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            // Simple success message
            echo "<script>alert('Message sent successfully!'); window.location.href = 'index.html';</script>";
        } else {
            // Simple failure message
            echo "<script>alert('Failed to send message. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields correctly.');</script>";
    }
}
?>
