<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'poll');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM prayojan WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) { // Direct comparison
            session_start();
            $_SESSION['email'] = $email;
            header('Location: welcome.php');
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
    <title>Login Page</title>
    <!-- MDBootstrap CSS (Bootstrap 5) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Input focus state */
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #709085 !important; /* Custom color for the border when focused */
            box-shadow: 0 0 5px rgba(112, 144, 133, 0.5) !important; /* Custom shadow effect */
            outline: none !important; /* Remove the default outline */
            border-width: 2px !important; /* Ensure border width is consistent */
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
            /* Adjusted height to accommodate navbar or other elements */
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
            border: 2px solid #709085 !important; /* Custom border to prevent Bootstrap override */
            border-radius: 5px !important; /* Custom border-radius */
        }

        /* Custom styles for the login button */
        .btn-info {
            background-color: #709085 !important; /* Override the Bootstrap color */
            border-color: #709085 !important;
        }
    </style>
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-black">

                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-balance-scale fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                        <span class="h4 fw-bold mb-0">Gurkha Law & Associates</span>
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <!-- Form using POST method -->
                        <form style="width: 23rem;" id="loginForm" method="POST" action="">
                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

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

                            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
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
