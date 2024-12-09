<?php
// Include necessary files
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php'; // Ensure this file sets up the $conn variable correctly

// Check if the database connection is established
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch pending verifications
$pendingVerifications = $conn->query("
    SELECT vd.id AS verification_id, p.id AS user_id, p.name, p.email, vd.document, vd.photo, vd.status 
    FROM verification_documents vd 
    JOIN prayojan p ON vd.user_id = p.id 
    WHERE vd.status = 'pending'
");

// Fetch user reports
$userReports = $conn->query("
    SELECT notifications.id AS notification_id, notifications.message, notifications.created_at, 
           polls.question AS poll_question, 
           reporter.name AS reporter_name, 
           creator.name AS poll_creator_name
    FROM notifications
    LEFT JOIN polls ON polls.id = notifications.poll_id
    LEFT JOIN prayojan AS reporter ON reporter.id = notifications.user_id
    LEFT JOIN prayojan AS creator ON creator.id = polls.user_id
    WHERE notifications.is_read = FALSE
");

// Mark all notifications as read
$conn->query("UPDATE notifications SET is_read = TRUE WHERE is_read = FALSE");

// Handle user approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verification_action'])) {
    $verificationId = $_POST['verification_id'];
    $userId = $_POST['user_id'];
    $action = $_POST['verification_action'];

    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $updateVerification = $conn->query("
        UPDATE verification_documents SET status = '$status' WHERE id = '$verificationId'
    ");

    if ($updateVerification) {
        if ($status === 'approved') {
            $conn->query("UPDATE prayojan SET verified = TRUE WHERE id = '$userId'");
        }
        echo "<script>alert('Verification $status successfully.'); window.location.href = 'notifications.php';</script>";
    }
}

// Handle report acknowledgment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acknowledge_report'])) {
    $reportId = $_POST['report_id'];
    $conn->query("UPDATE notifications SET is_read = TRUE WHERE id = '$reportId'");
    echo "<script>alert('Report acknowledged successfully.'); window.location.href = 'notifications.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
   body { 
    background-color: #f8f9fa;
    margin: 0; /* Remove default body margin */
    padding: 0; /* Remove default body padding */
}

.main-container {
    display: flex;
    height: 100vh; /* Full viewport height */
}

.sidebar {
    width: 250px;
    background-color: #f1f1f1; /* Optional: Add background color for sidebar */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional: Add shadow to sidebar */
}

.content {
    flex: 1;
    padding: 20px;
    margin: 0; /* Remove margin to align perfectly with sidebar */
    box-sizing: border-box; /* Ensure padding doesn't add extra width */
}

.card {
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden; /* Ensure content doesn't overflow */
}

.card-header {
    font-weight: bold;
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 15px;
    background-color: #fff; /* Add consistent background color for the card body */
}

.btn-group {
    display: flex;
    gap: 10px;
}

table th, table td {
    vertical-align: middle;
    text-align: center; /* Center-align table text for better readability */
}

.table-container {
    margin-top: 20px;
}

    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php include '../includes/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>Notifications</h1>

            <!-- Pending Verifications -->
            <div class="card">
                <div class="card-header">Pending User Verifications</div>
                <div class="card-body">
                    <?php if ($pendingVerifications->num_rows > 0): ?>
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Document</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($verification = $pendingVerifications->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($verification['name']); ?></td>
                                        <td><?php echo htmlspecialchars($verification['email']); ?></td>
                                        <td><a href="<?php echo htmlspecialchars($verification['document']); ?>" target="_blank">View Document</a></td>
                                        <td><a href="<?php echo htmlspecialchars($verification['photo']); ?>" target="_blank">View Photo</a></td>
                                        <td>
                                            <form method="post" style="display: inline-block;">
                                                <input type="hidden" name="verification_id" value="<?php echo $verification['verification_id']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $verification['user_id']; ?>">
                                                <button type="submit" name="verification_action" value="approve" class="btn btn-success">Approve</button>
                                                <button type="submit" name="verification_action" value="reject" class="btn btn-danger">Reject</button>
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
            </div>

            <!-- User Reports -->
            <div class="card">
                <div class="card-header">User Reports</div>
                <div class="card-body">
                    <?php if ($userReports->num_rows > 0): ?>
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Report Message</th>
                                    <th>Poll Question</th>
                                    <th>Reported By</th>
                                    <th>Poll Creator</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($report = $userReports->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($report['message']); ?></td>
                                        <td><?php echo htmlspecialchars($report['poll_question']); ?></td>
                                        <td><?php echo htmlspecialchars($report['reporter_name']); ?></td>
                                        <td><?php echo htmlspecialchars($report['poll_creator_name']); ?></td>
                                        <td>
                                            <form method="post" style="display: inline-block;">
                                                <input type="hidden" name="report_id" value="<?php echo $report['notification_id']; ?>">
                                                <button type="submit" name="acknowledge_report" class="btn btn-warning">Acknowledge</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">No user reports available.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
