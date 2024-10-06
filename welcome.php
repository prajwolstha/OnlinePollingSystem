<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

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

        .sidebar {
            width: 250px;
            background-color: #0d1b2a; /* Dark blue color */
            color: white;
            padding: 20px;
            position: fixed; /* Make sidebar fixed */
            height: 100%;
        }

        .content {
            margin-left: 270px; /* Ensure content doesn't overlap sidebar */
            padding: 20px;
            background-color: #f5f5f5; /* Light background color */
            flex-grow: 1;
        }

        .sidebar h4 {
            color: white;
            margin-top: 10px;
        }

        .verified {
            color: blue;
            margin-left: 5px;
        }

        .menu-item {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px 0;
            border-bottom: 1px solid #324c65;
        }

        .menu-item:hover {
            background-color: #1a2c41;
            cursor: pointer;
        }

        .section h3 {
            margin-bottom: 15px;
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

    <!-- Sidebar Section -->
    <div class="sidebar">
        <div class="text-center">
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic">
            <h4>
                <?php echo htmlspecialchars($user['name']); ?>
                <?php if ($user['verified']): ?>
                    <span class="verified"><img src="verified.png" alt="img"></span> <!-- Blue Tick for verified users -->
                <?php endif; ?>
            </h4>
        </div>

        <!-- Sidebar Menu -->
        <div class="menu">
            <a href="welcome.php" class="menu-item menu-item-active">Profile</a>
            <a href="poll_management.php" class="menu-item">Poll Management</a>
            <a href="poll_results.php" class="menu-item">Poll Results</a>
            <a href="notifications.php" class="menu-item">Notifications</a>
            <a href="user_analytics.php" class="menu-item">User Analytics</a>
            <a href="vote.php" class="menu-item">Vote</a> <!-- New Vote section added here -->
        </div>
    </div>

    <!-- Content Section -->
    <div class="content">
        <!-- User Profile Section -->
        <div class="section">
            <h3>Your Profile</h3>
            <form method="POST" action="welcome.php">
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
            <form method="POST" action="welcome.php">
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

        <!-- Update Profile Picture Section -->
        <div class="section">
            <h3>Update Profile Picture</h3>
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic mb-3">
            <form method="POST" action="welcome.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="file" class="form-control" name="profile_pic" required>
                </div>
                <button type="submit" name="update_profile_pic" class="btn btn-success">Update Profile Picture</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
