<?php
session_start();

// Check if admin is logged in (add admin authentication logic here)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'poll');

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
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Dashboard</h2>
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
                            <td><?php echo htmlspecialchars($row['document']); ?></td>
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
</body>
</html>
