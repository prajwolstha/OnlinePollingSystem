<?php
$email = $_POST['email'];
$otp = $_POST['otp'];

$to = $email;
$from = "noreply@invitkacodersclub.tech";
$fromName = "Invitka Coders";
$subject = "OTP Authentication";
$message = "Your OTP is: " . $otp;
$header = 'From: ' . $fromName . ' <' . $from . '>';

if (mail($to, $subject, $message, $header)) {
    $msg = "Successful";
}
?>

<form action="submitotp.php" method="POST">
    Enter OTP
    <input type="number" name="checkotp" placeholder="Enter OTP">
    <input type="hidden" name="otp" value="<?php echo $otp; ?>">
    <button type="submit">Verify</button>
</form>
