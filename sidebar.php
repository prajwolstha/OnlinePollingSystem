

<?php
// sidebar.php

// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli('localhost', 'root', '', 'poll');

// Fetch user details
$email = $_SESSION['email'] ?? '';
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$profile_pic = $user['profile_pic'] ?? 'uploads/default_profile.png'; // Fallback to default profile picture

?>

<!-- Sidebar Styles -->
<style>
    .sidebar {
        width: 250px;
        background-color: #0d1b2a; /* Dark blue color */
        color: white;
        padding: 20px;
        position: fixed; /* Make sidebar fixed */
        height: 100%;
    }

    .text-center {
        text-align: center;
    }

    .profile-pic {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
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
</style>

<!-- Sidebar Content -->
<div class="sidebar">
    <div class="text-center">
        <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic">
        <h4>
            <?php echo htmlspecialchars($user['name'] ?? 'Guest'); ?>
            <?php if (!empty($user['verified'])): ?>
                <span class="verified"><img src="verified.png" alt="Verified"></span> <!-- Blue Tick for verified users -->
            <?php endif; ?>
        </h4>
    </div>

    <!-- Sidebar Menu -->
    <div class="menu">
        <a href="index.php" class="menu-item menu-item-active">Profile</a>
        <a href="poll_management.php" class="menu-item">Poll Management</a>
        <a href="poll_results.php" class="menu-item">Poll Results</a>
        <a href="notifications.php" class="menu-item">Notifications</a>
        <a href="user_analytics.php" class="menu-item">User Analytics</a>
        <a href="vote.php" class="menu-item">Vote</a> <!-- New Vote section added here -->
    </div>
</div>
