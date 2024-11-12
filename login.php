<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hashing the password with MD5 (consider using more secure methods like password_hash in real applications)

    $sql = "SELECT * FROM prayojan WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['email'] = $email;
           $_SESSION['id'] = $user['id']; // Set the user ID in session

            header('Location: index.php'); // Redirect to the index page after successful login
        } else {
            echo "<div class='alert alert-danger'>Invalid password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>User not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Polling System</title>
    <!-- MDBootstrap CSS (Bootstrap 5) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="favicon.png">


    <style>
        /* Input focus state */
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #709085 !important;
            box-shadow: 0 0 5px rgba(112, 144, 133, 0.5) !important;
            outline: none !important;
            border-width: 2px !important;
        }

        /* Custom form styles */
        .bg-image-vertical {
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-position: right center;
            background-size: cover;
        }

        .h-custom-2 {
            height: calc(100vh - 60px);
        }

        .container-fluid {
            height: 100vh;
        }

        .d-flex.align-items-center {
            height: 90%;
        }

        .form-outline {
            position: relative;
            margin-bottom: 1.5rem;
        }

        /* Additional form input styles */
        input[type="email"], input[type="password"] {
            border-radius: 5px !important;
        }

        /* Custom styles for the login button */
        .btn-info {
            background-color: #2ba5e8 !important;
            border-color: #2ba5e8 !important;
        }

        .fas.fa-user-circle.fa-2x.me-3.pt-5.mt-xl-4 {
            color: #2ba5e8 !important;
        }

        /* Style for error message */
        .alert-danger {
            margin-top: 10px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #842029;
            padding: 10px;
            border: 1px solid #f5c2c7;
        }

        /* Separator style */
        .separator {
            text-align: center;
            margin: 20px 0;
            font-size: 0.9rem;
            color: #888;
        }

        /* Style for guest button */
        .btn-guest {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: #fff !important;
            width: 100%;
        }

        /* Spacing below the title */
        .title-spacing {
            margin-bottom: 2rem; /* Adjust spacing as needed */
        }
    </style>
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-black">
                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-user-circle fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                        <span class="h4 fw-bold mb-0 title-spacing">Online Polling System</span> <!-- Added class for spacing -->
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <!-- Form using POST method -->
                        <form style="width: 23rem;" id="loginForm" method="POST" action="">

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                <label class="form-label" for="email">Email address</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="pt-1 mb-4">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="submit" name="submit">Login</button>
                            </div>

                            <!-- Display error message below the login button if there's an error -->
                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php endif; ?>

                            <!-- Separator with "or" -->
                            <div class="separator">or</div>

                            <!-- Continue as Guest button -->
                            <div class="mb-4">
                                <a href="guest.php" class="btn btn-guest btn-lg">Continue as Guest</a>
                            </div>

                            <p class="small mb-5 pb-lg-2">New User?<a class="text-muted" href="register.php"> Register</a>.<a class="text-muted" href="#!"> Forgot Password?</a></p>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="front.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>

    <!-- MDBootstrap JS (Bootstrap 5) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>

</html>