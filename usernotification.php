<?php
include 'connection.php';


// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['id'];

// Fetch notifications for the logged-in user
$sql = "SELECT * FROM user_notifications WHERE user_id='$userId' ORDER BY created_at DESC";
$notifications = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .content {
            margin-left: 250px; /* Adjust to the sidebar width */
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <div class="container mt-5">
            <h3>User Notifications</h3>
            <?php if ($notifications->num_rows > 0): ?>
                <ul class="list-group">
                    <?php while ($notification = $notifications->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <strong>Message:</strong> 
                            <?php echo htmlspecialchars($notification['message']); ?><br>
                            <small><em><?php echo date('Y-m-d H:i:s', strtotime($notification['created_at'])); ?></em></small>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <div class="alert alert-info">No notifications available.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

