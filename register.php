<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dstudios_poll');

// Function to send OTP
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'prazolstha12345@gmail.com';
        $mail->Password = 'rlxv vxfq tttk spyh';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('noreply@gmail.com', 'Online Polling System');
        $mail->addAddress($email);

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'OTP Verification';
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
                        margin: 20px auto;
                        background-color: #ffffff;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        background-color: #2ba5e8;
                        color: #ffffff;
                        text-align: center;
                        padding: 20px;
                        font-size: 24px;
                        font-weight: bold;
                    }
                    .email-body {
                        padding: 20px;
                        font-size: 16px;
                        color: #333333;
                        line-height: 1.5;
                    }
                    .otp {
                        background-color: #f4f4f4;
                        border: 1px dashed #2ba5e8;
                        color: #2ba5e8;
                        font-size: 20px;
                        font-weight: bold;
                        text-align: center;
                        margin: 20px 0;
                        padding: 10px;
                        border-radius: 5px;
                    }
                    .email-footer {
                        background-color: #f4f4f4;
                        text-align: center;
                        padding: 10px;
                        font-size: 14px;
                        color: #888888;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>Online Polling System</div>
                    <div class='email-body'>
                        <p>Hello,</p>
                        <p>Your One-Time Password (OTP) for registration is:</p>
                        <div class='otp'>{$otp}</div>
                        <p>Please use this OTP to complete your registration. If you did not request this, please ignore this email.</p>
                        <p>Thank you,<br>Online Polling System Team</p>
                    </div>
                    <div class='email-footer'>
                        &copy; " . date('Y') . " Online Polling System. All rights reserved.
                    </div>
                </div>
            </body>
        </html>";
        $mail->AltBody = 'Your OTP for registration is: ' . $otp;

        $mail->send();
        echo "<script>alert('OTP sent to $email');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: Could not send OTP.');</script>";
    }
}

$registrationMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['request_otp'])) {
        $email = $_POST['email'];

        // Check if email already exists
        $checkEmailSql = "SELECT * FROM prayojan WHERE email = ?";
        $stmt = $conn->prepare($checkEmailSql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $registrationMessage = 'This email is already registered.';
        } else {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            sendOTP($email, $otp);
            $registrationMessage = 'OTP sent to your email.';
        }
    } elseif (isset($_POST['verify_otp'])) {
        $user_otp = $_POST['otp'];
        if ($user_otp == $_SESSION['otp']) {
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $registrationMessage = 'Passwords do not match.';
            } else {
                $password = md5($_POST['password']);
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $country = $_POST['country'];
                $address = $_POST['address'];
                $email = $_SESSION['email'];

                $sql = "INSERT INTO prayojan (password, name, phone, country, address, email) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssss', $password, $name, $phone, $country, $address, $email);

                if ($stmt->execute()) {
                    header('location:login.php');
                    exit;
                } else {
                    $registrationMessage = 'Error during registration: ' . $stmt->error;
                }
            }
        } else {
            $registrationMessage = 'Incorrect OTP! Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Polling System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <style>
        .container-fluid { height: 100vh; }
        .register-section { height: 90%; }
        .form-outline { position:relative; }
        .btn-primary {
            background-color: #2ba5e8 !important;
            border-color: #2ba5e8 !important;
            border: 1px solid #2ba5e8 !important;
        }
        .alert-success, .alert-danger {
            margin-top: 10px;
            border-radius: 5px;
        }
        .header-text {
            color: #000;
            font-weight: bold;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        .row-spacing { margin-bottom: 1rem; }
        .form-outline input { padding: 0.75rem; }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-black">
                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-user-circle fa-2x me-3 pt-5 mt-xl-4" style="color: #2ba5e8;"></i>
                        <!-- <span class="header-text">Register - Online Polling System</span> -->
                    </div>
                    <div class="d-flex align-items-center register-section px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <form style="width: 23rem;" method="post" action="" onsubmit="return submitForm();">
                            <?php if (!empty($registrationMessage)): ?>
                                <div class="alert alert-info"><?php echo $registrationMessage; ?></div>
                            <?php endif; ?>
                            <div class="row row-spacing">
                                <div class="col-md-6"><div class="form-outline"><input type="text" id="name" name="name" class="form-control form-control-lg" required /><label class="form-label" for="name">Name</label></div></div>
                                <div class="col-md-6"><div class="form-outline"><input type="tel" id="phone" name="phone" class="form-control form-control-lg" required /><label class="form-label" for="phone">Phone</label></div></div>
                            </div>
                            <div class="row row-spacing">
                                <div class="col-md-6"><div class="form-outline"><input type="text" id="country" name="country" class="form-control form-control-lg" required /><label class="form-label" for="country">Country</label></div></div>
                                <div class="col-md-6"><div class="form-outline"><input type="text" id="address" name="address" class="form-control form-control-lg" required /><label class="form-label" for="address">Address</label></div></div>
                            </div>
                            <div class="form-outline row-spacing">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                <label class="form-label" for="email">Email</label>
                                <div id="emailError" style="color: red; font-size: 0.9rem;"></div>
                            </div>
                            <button type="button" class="btn btn-info btn-block mb-2" onclick="requestOTP()">Request OTP</button>
                            <div class="form-outline row-spacing"><input type="text" id="otp" name="otp" class="form-control form-control-lg" required /><label class="form-label" for="otp">Enter OTP</label></div>
                            <div class="form-outline row-spacing"><input type="password" id="password" name="password" class="form-control form-control-lg" required /><label class="form-label" for="password">Password</label></div>
                            <div class="form-outline row-spacing"><input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required /><label class="form-label" for="confirm_password">Confirm Password</label></div>
                            <div class="pt-1 mb-4"><button type="submit" class="btn btn-primary btn-lg btn-block" name="verify_otp">Register</button></div>
                            <div class="text-center"><p>Already have an account?<a href="login.php"> Login here.</a></p></div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="front.jpg" alt="Register image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
    <script>
        document.getElementById('email').addEventListener('blur', function () {
            const email = this.value;
            const emailError = document.getElementById('emailError');

            if (email) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_email.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.responseText === 'exists') {
                        emailError.textContent = 'This email is already registered.';
                    } else {
                        emailError.textContent = '';
                    }
                };
                xhr.send('email=' + email);
            }
        });

        function requestOTP() {
            const email = document.getElementById('email').value;
            const emailError = document.getElementById('emailError');

            if (emailError.textContent === '') {
                // Proceed only if no email error
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    alert('OTP sent to your email');
                };
                xhr.send('email=' + email + '&request_otp=1');
            } else {
                alert('Please fix the email issue first.');
            }
        }

        function submitForm() {
            const otpInput = document.getElementById('otp').value;
            if (!otpInput) {
                alert('Please enter the OTP sent to your email.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
