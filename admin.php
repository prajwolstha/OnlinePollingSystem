<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'poll');

// Fetch unread notifications
$notificationSql = "SELECT * FROM notifications WHERE is_read = FALSE";
$notifications = $conn->query($notificationSql);

// Mark all notifications as read when the page is loaded
$conn->query("UPDATE notifications SET is_read = TRUE WHERE is_read = FALSE");

// Approve or reject user verification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentId = $_POST['document_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $sql = "UPDATE verification_documents SET status='$status' WHERE id='$documentId'";
    if ($conn->query($sql) === TRUE) {
        if ($status === 'approved') {
            // Update user verification status
            $userId = $_POST['user_id'];
            $conn->query("UPDATE prayojan SET verified=TRUE WHERE id='$userId'");
        }
        echo "<div class='alert alert-success'>User verification updated.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch pending verifications
$sql = "SELECT vd.*, p.name, p.email 
        FROM verification_documents vd 
        JOIN prayojan p ON vd.user_id = p.id 
        WHERE vd.status='pending'";
$pendingVerifications = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .notifications {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Dashboard</h2>

        <!-- Notifications Section -->
        <?php if ($notifications->num_rows > 0): ?>
            <div class="notifications">
                <h4>New Notifications</h4>
                <ul>
                    <?php while ($notification = $notifications->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($notification['message']); ?> (<?php echo date('Y-m-d H:i:s', strtotime($notification['created_at'])); ?>)</li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No new notifications.</div>
        <?php endif; ?>

        <h3>Pending Verifications</h3>
        
        <?php if ($pendingVerifications->num_rows > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Document</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $pendingVerifications->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <!-- Display the document link or info securely -->
                                <a href="<?php echo htmlspecialchars($row['document']); ?>" target="_blank">View Document</a>
                            </td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="document_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No pending verifications.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
