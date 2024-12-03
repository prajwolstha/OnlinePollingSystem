<?php
$checkotp = $_POST['checkotp'];
$otp = $_POST['otp'];

if ($checkotp == $otp) {
    echo "OTP Verified and Signup completed";
} else {
    echo "Incorrect OTP!";
}
?>
