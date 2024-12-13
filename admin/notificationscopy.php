<?php
// Include necessary files
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php'; // Ensure this file sets up the $conn variable correctly

// Establish database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch pending verifications
$pendingVerificationsQuery = "
    SELECT vd.id AS verification_id, p.id AS user_id, p.name, p.email, vd.document, vd.photo, vd.status 
    FROM verification_documents vd 
    JOIN prayojan p ON vd.user_id = p.id 
    WHERE vd.status = 'pending'
";
$pendingVerifications = mysqli_query($conn, $pendingVerificationsQuery);

// Fetch user reports
$userReportsQuery = "
    SELECT notifications.id AS notification_id, notifications.message, notifications.created_at, 
           polls.question AS poll_question, 
           reporter.name AS reporter_name, 
           creator.name AS poll_creator_name
    FROM notifications
    LEFT JOIN polls ON polls.id = notifications.poll_id
    LEFT JOIN prayojan AS reporter ON reporter.id = notifications.user_id
    LEFT JOIN prayojan AS creator ON creator.id = polls.user_id
    WHERE notifications.is_read = FALSE
";
$userReports = mysqli_query($conn, $userReportsQuery);

// Mark all notifications as read
mysqli_query($conn, "UPDATE notifications SET is_read = TRUE WHERE is_read = FALSE");

// Handle user approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verification_action'])) {
    $verificationId = mysqli_real_escape_string($conn, $_POST['verification_id']);
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $action = mysqli_real_escape_string($conn, $_POST['verification_action']);

    $status = ($action === 'approve') ? 'approved' : 'rejected';
    $updateVerificationQuery = "
        UPDATE verification_documents SET status = '$status' WHERE id = '$verificationId'
    ";
    $updateVerification = mysqli_query($conn, $updateVerificationQuery);

    if ($updateVerification) {
        if ($status === 'approved') {
            mysqli_query($conn, "UPDATE prayojan SET verified = TRUE WHERE id = '$userId'");
        }
        echo "<script>alert('Verification $status successfully.'); window.location.href = 'notifications.php';</script>";
    }
}

// Handle report acknowledgment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acknowledge_report'])) {
    $reportId = mysqli_real_escape_string($conn, $_POST['report_id']);
    mysqli_query($conn, "UPDATE notifications SET is_read = TRUE WHERE id = '$reportId'");
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
            margin: 0;
            padding: 0;
        }
        .main-container {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #f1f1f1;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .content {
            flex: 1;
            padding: 20px;
            margin: 0;
            box-sizing: border-box;
        }
        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
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
            background-color: #fff;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
        table th, table td {
            vertical-align: middle;
            text-align: center;
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
                    <?php if (mysqli_num_rows($pendingVerifications) > 0): ?>
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
                                <?php while ($verification = mysqli_fetch_assoc($pendingVerifications)): ?>
                                    <tr>
                                        <td><?php echo $verification['name']; ?></td>
                                        <td><?php echo $verification['email']; ?></td>
                                        <td><a href="<?php echo $verification['document']; ?>" target="_blank">View Document</a></td>
                                        <td><a href="<?php echo $verification['photo']; ?>" target="_blank">View Photo</a></td>
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
                    <?php if (mysqli_num_rows($userReports) > 0): ?>
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
                                <?php while ($report = mysqli_fetch_assoc($userReports)): ?>
                                    <tr>
                                        <td><?php echo $report['message']; ?></td>
                                        <td><?php echo $report['poll_question']; ?></td>
                                        <td><?php echo $report['reporter_name']; ?></td>
                                        <td><?php echo $report['poll_creator_name']; ?></td>
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
