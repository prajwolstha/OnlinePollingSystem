<?php
// Database connection
include 'connection.php';
header('Content-Type: application/json');

// Enable error reporting for debugging (optional in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



// Check if email is provided
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
    $result = $conn->query("SELECT id FROM prayojan WHERE email='$email'");

    // Check if email already exists
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email is already registered.']);
        exit();
    }

    // Generate and store OTP in session
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = date("Y-m-d H:i:s", strtotime("+2 minutes"));
    $_SESSION['otp_email'] = $email;

    // Send OTP email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.dstudiosnepal.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@dstudiosnepal.com';
        $mail->Password = '?xCol{BXUFnm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('noreply@dstudiosnepal.com', 'Online Polling System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';

        // Styled HTML email content
        $mail->Body = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 600px;
                    margin: auto;
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                }
                .header {
                    font-size: 24px;
                    font-weight: bold;
                    color: #333;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .otp-code {
                    font-size: 32px;
                    color: #2ba5e8;
                    font-weight: bold;
                    text-align: center;
                    background-color: #f4f4f4;
                    padding: 15px;
                    border-radius: 8px;
                    margin: 20px 0;
                }
                .message {
                    font-size: 16px;
                    color: #555;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .footer {
                    font-size: 14px;
                    color: #888;
                    text-align: center;
                    padding-top: 10px;
                }
                .automated-message {
                    font-size: 12px;
                    color: #888;
                    text-align: center;
                    margin-top: 10px;
                    font-style: italic;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>Your OTP Code</div>
                <div class='message'>Please use the following code to complete your registration:</div>
                <div class='otp-code'>$otp</div>
                <div class='message'>This code is valid for 2 minutes. If you did not request this, please ignore this email.</div>
                <div class='footer'>Thank you for using our service.<br>Online Polling System Team</div>
                <div class='automated-message'>This is an automated message; please do not reply.</div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error in sending OTP: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email.']);
}
exit();