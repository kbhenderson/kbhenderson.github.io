<?php
// Config
$sendto = 'krishenderson50@outlook.com';
$subject = "New Quote Request";

if ( ! empty( $_POST ) ) {
    // Whitelist
    $name = $_POST['name'];
    $from = $_POST['email'];
    $message = $_POST['message'];
    $honeypot = $_POST['url'];

    // Check honeypot
    if (!empty($honeypot)) {
        echo json_encode(array('status'=>0, 'message'=>'There was a problem.'));

        die();
    }

    // Check for empty values
    if (empty($name) || empty($from) || empty($message)) {
        echo json_encode(array('status'=>0, 'message'=>'A field is missing.'));

        die();
    }

    // Check for valid email
    $from = filter_var($from, FILTER_VALIDATE_EMAIL);


    if (!$from) {
        echo json_encode(array('status'=>0, 'message'=>'Not a valid email.'));

        die();
    }

    // Send email
    $headers = sprintf('From: %s', $from) . "\r\n";
    $headers .= sprintf('Reply-To: %s', $from) . "\r\n";
    $headers .= sprintf('X-Mailer: PHP/%s', phpversion());

    if ( mail($sendto, $subject, $message, $headers) ) {
        echo json_encode(array('status'=>1, 'message'=>'Email sent successfully.'));

        die();
    }

    // Return negative message if email send failed
    echo json_encode(array('status'=>0, 'message'=>'Email NOT sent successfully. Please try again.'));
}
