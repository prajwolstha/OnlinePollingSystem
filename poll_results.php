<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error); // Display SQL error if any
}

$user = $result->fetch_assoc();
$profile_pic = $user['profile_pic'] ?? 'uploads/default_profile.png'; // Fallback to default profile picture

// Fetch all polls
$sql = "SELECT * FROM polls";
$polls = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar and content layout styling */
        .sidebar {
            width: 250px;
            background-color: #0d1b2a;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
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

        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px 0;
            background-color: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center">
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic">
            <h4><?php echo htmlspecialchars($user['name']); ?></h4>
            <?php if ($user['verified']): ?>
                <span class="verified"><img src="verified.png" alt="Verified"></span> <!-- Verification logo -->
            <?php endif; ?>
        </div>

        <!-- Sidebar Menu -->
        <div class="menu">
            <a href="welcome.php" class="menu-item">Profile</a>
            <a href="poll_management.php" class="menu-item">Poll Management</a>
            <a href="poll_results.php" class="menu-item menu-item-active">Poll Results</a>
            <a href="notifications.php" class="menu-item">Notifications</a>
            <a href="user_analytics.php" class="menu-item">User Analytics</a>
            <a href="vote.php" class="menu-item">Vote</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Poll Results</h2>

        <?php while ($poll = $polls->fetch_assoc()): ?>
            <div class="section mb-4">
                <h4><?php echo htmlspecialchars($poll['question']); ?></h4>

                <!-- Fetch options and votes for the current poll -->
                <?php
                $poll_id = $poll['id'];
                $options_sql = "SELECT * FROM poll_options WHERE poll_id = $poll_id";
                $options = $conn->query($options_sql);
                ?>

                <ul class="list-group">
                    <?php while ($option = $options->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($option['option_text']); ?> 
                            <span class="badge bg-primary"><?php echo $option['votes']; ?> votes</span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
