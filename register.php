<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = md5($_POST['password']);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $sql = "INSERT INTO prayojan (password, name, phone, country, address, email) 
            VALUES ('$password', '$name', '$phone', '$country', '$address', '$email')";

    if ($conn->query($sql) === TRUE) {
        header('location:login.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Polling System</title>
    <!-- MDBootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="favicon.png">

    
    <style>
        .container-fluid {
            height: 100vh;
        }
        
        .register-section {
            height: 90%;
        }

        .form-outline {
            position: relative;
        }

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

        /* Spacing adjustments for a uniform look */
        .row-spacing {
            margin-bottom: 1rem; /* Consistent spacing for each row */
        }

        .form-outline input {
            padding: 0.75rem;
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Section -->
                <div class="col-sm-6 text-black">
                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-user-circle fa-2x me-3 pt-5 mt-xl-4" style="color: #2ba5e8;"></i>
                        <span class="header-text">Register - Online Polling System</span>
                    </div>

                    <div class="d-flex align-items-center register-section px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <form style="width: 23rem;" method="post" action="">
                            <div class="row row-spacing">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" id="name" name="name" class="form-control form-control-lg" required />
                                        <label class="form-label" for="name">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="tel" id="phone" name="phone" class="form-control form-control-lg" required />
                                        <label class="form-label" for="phone">Phone</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-spacing">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" id="country" name="country" class="form-control form-control-lg" required />
                                        <label class="form-label" for="country">Country</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" id="address" name="address" class="form-control form-control-lg" required />
                                        <label class="form-label" for="address">Address</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-outline row-spacing">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                <label class="form-label" for="email">Email</label>
                            </div>

                            <div class="form-outline row-spacing">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="pt-1 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                            </div>

                            <div class="text-center">
                                <p></p>Already have an account?<a href="login.php"> Login here.</a></p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="front.jpg" alt="Register image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>

    <!-- MDBootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>


