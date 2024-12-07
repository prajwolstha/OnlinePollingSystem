<?php 
include 'connection.php';
// Redirect to login page if user is not logged in
// if (!isset($_SESSION['email'])) {
//     header("Location: login.php");
//     exit();
// }


// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$profile_pic = $user['profile_pic'] ?? 'uploads/default_profile.png'; // Fallback to default profile picture

$error_message = "";

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $updatedName = $_POST['name'];
    $updatedEmail = $_POST['email'];

    // Update query
    $sql = "UPDATE prayojan SET name='$updatedName', email='$updatedEmail' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        $error_message = "Profile updated successfully.";
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword == $confirmPassword) {
        // Check if current password is correct
        $currentPasswordHashed = md5($currentPassword);
        if ($user['password'] == $currentPasswordHashed) {
            // Update password
            $newPasswordHashed = md5($newPassword);
            $sql = "UPDATE prayojan SET password='$newPasswordHashed' WHERE email='$email'";
            if ($conn->query($sql) === TRUE) {
                $error_message = "Password changed successfully.";
            } else {
                $error_message = "Error updating password: " . $conn->error;
            }
        } else {
            $error_message = "Current password is incorrect.";
        }
    } else {
        $error_message = "New passwords do not match.";
    }
}

// Handle profile picture update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile_pic'])) {
    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $fileType = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        if (in_array($fileType, $allowedTypes)) {
            $profilePicPath = 'uploads/' . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePicPath)) {
                $sql = "UPDATE prayojan SET profile_pic='$profilePicPath' WHERE email='$email'";
                if ($conn->query($sql) === TRUE) {
                    $error_message = "Profile picture updated successfully!";
                } else {
                    $error_message = "Error updating profile picture: " . $conn->error;
                }
            } else {
                $error_message = "Failed to upload profile picture.";
            }
        } else {
            $error_message = "Only JPG, JPEG, and PNG formats are allowed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling for error message */
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            text-align: center;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* Profile Section */
        .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px 0;
            background-color: white;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        /* Layout Styles */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f5f5f5;
            flex-grow: 1;
        }

        .section h3 {
            margin-bottom: 15px;
        }

        .logout {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Display error message if exists -->
    <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>


    <?php include 'sidebar.php'; ?>

    <!-- Content Section -->
    <div class="content">
        <!-- Update Profile Picture Section -->
        <div class="section">
            <h3>Update Profile Picture</h3>
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic mb-3">
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="file" class="form-control" name="profile_pic" accept=".jpg, .jpeg, .png" required>
                </div>
                <button type="submit" name="update_profile_pic" class="btn btn-success">Update Profile Picture</button>
            </form>
        </div>

        <!-- User Profile Section -->
        <div class="section">
            <h3>Your Profile</h3>
            <form method="POST" action="index.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
            </form>
        </div>

        <!-- Change Password Section -->
        <div class="section">
            <h3>Change Password</h3>
            <form method="POST" action="index.php">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-warning">Change Password</button>
            </form>
        </div>

        <button type="submit" name="logout" class="btn btn-danger">
            <a href="logout.php" class="logout">Logout</a>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
