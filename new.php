<?php
include 'connection.php';

function generateOTP() {
    return rand(100000, 999999);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $password = md5($_POST['password']);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    // Generate and send OTP
    $otp = generateOTP();
    $otp_expiry = date("Y-m-d H:i:s", strtotime('+10 minutes'));

    // Save the OTP in the session for later verification
    session_start();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email; // Store email in session to use in the verification step

    // Dummy function to simulate sending email
    echo "OTP to verify: " . $otp; // In production, you would replace this with a mail function

    // Store user data in session temporarily
    $_SESSION['temp_data'] = ['password' => $password, 'name' => $name, 'phone' => $phone, 'country' => $country, 'address' => $address, 'email' => $email];

    // Redirect to verify OTP page or refresh the page to show OTP input
    header("location: register.php?verify=true");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
    session_start();
    $user_otp = $_POST['user_otp'];

    // Compare user input OTP with the one stored in the session
    if ($user_otp == $_SESSION['otp']) {
        // Insert data into database as OTP is correct
        $data = $_SESSION['temp_data'];
        $sql = "INSERT INTO prayojan (password, name, phone, country, address, email) 
                VALUES ('{$data['password']}', '{$data['name']}', '{$data['phone']}', '{$data['country']}', '{$data['address']}', '{$data['email']}')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            // Clear the session data
            unset($_SESSION['otp']);
            unset($_SESSION['temp_data']);
            header('location:login.php');
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!-- Registration Form -->
<form method="post" action="">
    <input type="text" name="name" required placeholder="Name">
    <input type="tel" name="phone" required placeholder="Phone">
    <input type="text" name="country" required placeholder="Country">
    <input type="text" name="address" required placeholder="Address">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit" name="register">Register</button>
</form>

<?php if (isset($_GET['verify'])): ?>
<!-- OTP Verification Form -->
<form method="post" action="">
    <input type="text" name="user_otp" required placeholder="Enter OTP">
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
<?php endif; ?>

