<!-- <?php
// include 'connection.php';


// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
//     $otp = $_POST['otp'];
//     $user_id = $_SESSION['user_id']; // Retrieve user_id from session

//     // Validate OTP
//     $result = $conn->query("SELECT * FROM otp_verification WHERE user_id = '$user_id' AND otp = '$otp' AND otp_expiry > NOW()");
//     if ($result->num_rows > 0) {
//         // OTP is correct and not expired
//         header('Location: login.php'); // Redirect to login or confirmation page
//     } else {
//         echo "Invalid or expired OTP!";
//     }
// }
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="otp" required placeholder="Enter OTP">
        <button type="submit" name="verify_otp">Verify OTP</button>
    </form>
</body>
</html> -->
