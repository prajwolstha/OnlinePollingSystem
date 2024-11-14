<?php
include 'connection.php';
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch pending verifications
$sql = "SELECT vd.*, p.name, p.email 
        FROM verification_documents vd 
        JOIN prayojan p ON vd.user_id = p.id 
        WHERE vd.status='pending'";
$pendingVerifications = $conn->query($sql);

if (!$pendingVerifications) {
    echo "Error fetching pending verifications: " . $conn->error;
}

// Fetch unread notifications (poll creation and document submission notifications)
$notificationSql = "SELECT * FROM notifications WHERE is_read = FALSE";
$notifications = $conn->query($notificationSql);

// Mark all notifications as read when the page is loaded
$conn->query("UPDATE notifications SET is_read = TRUE WHERE is_read = FALSE");

// Approve or reject user verification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_action'])) {
    $documentId = $_POST['document_id'];
    $action = $_POST['user_action'];
    $status = ($action === 'approve') ? 'approved' : 'rejected';

    // Update the verification status in the verification_documents table
    $sql = "UPDATE verification_documents SET status='$status' WHERE id='$documentId'";
    if ($conn->query($sql) === TRUE) {
        if ($status === 'approved') {
            // Update user verification status
            $userId = $_POST['user_id'];
            $conn->query("UPDATE prayojan SET verified=TRUE WHERE id='$userId'");
        }
        echo "<div class='alert alert-success'>User verification updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Delete a poll
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['poll_action'])) {
    $pollId = $_POST['poll_id'];
    if ($_POST['poll_action'] === 'delete') {
        $sql = "DELETE FROM polls WHERE id='$pollId'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Poll deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Delete a user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];
    $sql = "DELETE FROM prayojan WHERE id='$userId'";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>User deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting user: " . $conn->error . "</div>";
    }
}

// Fetch all polls
$sql = "SELECT * FROM polls";
$polls = $conn->query($sql);

// Fetch all users
$sql = "SELECT * FROM prayojan";
$users = $conn->query($sql);
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
        .poll-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .poll-item {
            width: 100px;
            height: 100px;
            background-color: #f0f0f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        #pollResults {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Admin Dashboard</h2>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#polls" role="tab" data-bs-toggle="tab">Manage Polls</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#users" role="tab" data-bs-toggle="tab">Manage Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#notifications" role="tab" data-bs-toggle="tab">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#viewPolls" role="tab" data-bs-toggle="tab">View Polls</a>
            </li>
        </ul>

        <!-- Tab Panes -->
        <div class="tab-content">
            <!-- Poll Management Tab -->
            <div role="tabpanel" class="tab-pane active" id="polls">
                <h3>Manage Polls</h3>
                <?php if ($polls->num_rows > 0): ?>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Poll Question</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($poll = $polls->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($poll['question']); ?></td>
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                                            <button type="submit" name="poll_action" value="delete" class="btn btn-danger">Delete Poll</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No polls available.</div>
                <?php endif; ?>
            </div>

            <!-- User Management Tab -->
            <div role="tabpanel" class="tab-pane fade" id="users">
                <h3>Manage Users</h3>
                <!-- Pending Verifications Section -->
                <?php if ($pendingVerifications->num_rows > 0): ?>
                    <h4>Pending Verifications</h4>
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
                                    <td><a href="<?php echo htmlspecialchars($row['document']); ?>" target="_blank">View Passport</a></td>
                                    <td><a href="<?php echo htmlspecialchars($row['photo']); ?>" target="_blank">View Photo</a></td>
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="document_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="user_action" value="approve" class="btn btn-success">Approve</button>
                                            <button type="submit" name="user_action" value="reject" class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No pending verifications.</div>
                <?php endif; ?>

                <!-- All Users Section -->
                <h4>All Users</h4>
                <?php if ($users->num_rows > 0): ?>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['verified'] ? 'Yes' : 'No'; ?></td>
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete_user" value="delete" class="btn btn-danger">Delete User</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">No users available.</div>
                <?php endif; ?>
            </div>

            <!-- Notifications Tab -->
            <div role="tabpanel" class="tab-pane fade" id="notifications">
                <h3>Notifications</h3>
                <?php if ($notifications->num_rows > 0): ?>
                    <div class="notifications">
                        <ul>
                            <?php while ($notification = $notifications->fetch_assoc()): ?>
                                <li><?php echo htmlspecialchars($notification['message']); ?> (<?php echo date('Y-m-d H:i:s', strtotime($notification['created_at'])); ?>)</li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No new notifications.</div>
                <?php endif; ?>
            </div>

            <!-- View Polls Tab -->
            <div role="tabpanel" class="tab-pane fade" id="viewPolls">
                <h3>View Poll Results by User</h3>
                <form id="viewPollForm" method="POST">
                    <div class="mb-3">
                        <label for="userSelect" class="form-label">Select User:</label>
                        <select id="userSelect" class="form-control" name="user_id" required>
                            <option value="">Choose a user</option>
                            <?php
                            // Fetch users for the dropdown
                            $userResult = $conn->query("SELECT id, name FROM prayojan");
                            while ($user = $userResult->fetch_assoc()) {
                                echo "<option value='{$user['id']}'>{$user['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <!-- Display Polls Created by the Selected User -->
                <div id="pollList" class="poll-grid"></div>

                <!-- Poll Results Section -->
                <div id="pollResults" class="mt-4"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fetch polls based on selected user
        document.getElementById('userSelect').addEventListener('change', function () {
            const userId = this.value;
            const pollList = document.getElementById('pollList');
            pollList.innerHTML = '';
            if (userId) {
                fetch(`fetch_polls.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(poll => {
                            const pollItem = document.createElement('div');
                            pollItem.classList.add('poll-item');
                            pollItem.textContent = poll.question;
                            pollItem.onclick = () => fetchPollResults(poll.id);
                            pollList.appendChild(pollItem);
                        });
                    });
            }
        });

        // Fetch poll results for the selected poll
        function fetchPollResults(pollId) {
            if (pollId) {
                fetch(`fetch_poll_results.php?poll_id=${pollId}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsHtml = '<h4>Poll Results:</h4><ul class="list-group">';
                        data.forEach(option => {
                            resultsHtml += `<li class="list-group-item">${option.option_text}: ${option.votes} votes</li>`;
                        });
                        resultsHtml += '</ul>';
                        document.getElementById('pollResults').innerHTML = resultsHtml;
                    });
            }
        }
    </script>
</body>
</html>
