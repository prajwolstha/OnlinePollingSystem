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
        .register-section { height: 100%; }
        .form-outline { position: relative; }
        .btn-primary { background-color: #2ba5e8 !important; border-color: #2ba5e8 !important; }
        .header-text { color: #000; font-weight: bold; margin-bottom: 1.5rem; font-size: 1.5rem; }
        .row-spacing { margin-bottom: 1rem; }
        .form-outline input { padding: 0.75rem; }
        .otp-container { display: flex; align-items: center; }
        .otp-container input { flex: 1; margin-right: 10px; }
        .message { color: green; margin-top: 10px; }
        
        .form-control::placeholder {
            color: #757575 !important;
            opacity: 1 !important;
        }
        
        .form-control.form-control-lg {
            border: 1px solid #757575 !important;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function requestOTP() {
            const email = $("#email").val();
            if (!email) {
                alert("Please enter your email to request OTP.");
                return;
            }

            // AJAX call to request_otp.php to request OTP
            $.ajax({
                type: "POST",
                url: "request_otp.php",
                data: { email: email },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $(".message").text(response.message).css("color", "green");
                        alert("OTP sent successfully!"); // Show popup message
                        startCountdown();
                    } else {
                        $(".message").text(response.message).css("color", "red");
                        alert("Failed to send OTP. " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                    alert("An error occurred. Please try again.");
                }
            });
        }

        function startCountdown() {
            let timeLeft = 120;
            $("#otp-timer").text('2:00');
            const countdown = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                $("#otp-timer").text(${minutes}:${seconds < 10 ? '0' : ''}${seconds});
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    $("#otp-timer").text('Expired');
                }
            }, 1000);
        }
    </script>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-black">
                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-user-circle fa-2x me-3 pt-5 mt-xl-4" style="color: #2ba5e8;"></i>
                        <span class="header-text">Register - Online Polling System</span>
                    </div>

                    <div class="d-flex align-items-center register-section px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <form style="width: 100%;" method="post" action="register.php">
                            <div class="form-outline row-spacing">
                                <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" required>
                            </div>
                            <div class="form-outline row-spacing">
                                <input type="tel" name="phone" class="form-control form-control-lg" placeholder="Phone" required>
                            </div>
                            <div class="form-outline row-spacing">
                                <input type="text" name="country" class="form-control form-control-lg" placeholder="Country" required>
                            </div>
                            <div class="form-outline row-spacing">
                                <input type="text" name="address" class="form-control form-control-lg" placeholder="Address" required>
                            </div>
                            <div class="form-outline row-spacing">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                            </div>
                            
                            <!-- Email and OTP Request Button -->
                            <div class="form-outline row-spacing otp-container">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                                <button type="button" onclick="requestOTP()" class="btn btn-primary" style="padding: 14px 20px !important;">Request OTP</button>
                            </div>
                            
                            <!-- OTP Field -->
                            <div class="form-outline row-spacing">
                                <input type="text" id="otp" name="otp" class="form-control form-control-lg" placeholder="Enter OTP" required>
                                <div id="otp-timer" class="mt-1" style="font-size: 0.9rem; color: red;"></div>
                            </div>

                            <div class="pt-1 mb-4">
                                <button type="submit" name="register" class="btn btn-primary btn-lg btn-block">Register</button>
                            </div>

                            <div class="message"></div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="front.jpg" alt="Register image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>
</body>
</html>