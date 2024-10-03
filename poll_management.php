<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error); // Display SQL error if any
}

$user = $result->fetch_assoc();
$user_id = $user['id'];

// Handle poll creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_poll'])) {
    $poll_question = $_POST['poll_question'];
    $category = $_POST['category'];
    $poll_type = $_POST['poll_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $options = array_filter($_POST['options']); // Remove empty options

    if (!empty($poll_question) && count($options) > 1) {
        // Insert poll into the polls table
        $sql = "INSERT INTO polls (question, id, category, poll_type, start_date, end_date) 
                VALUES ('$poll_question', '$user_id', '$category', '$poll_type', '$start_date', '$end_date')";
        if ($conn->query($sql) === TRUE) {
            $poll_id = $conn->insert_id; // Get the ID of the newly created poll

            // Insert each option into the poll_options table
            foreach ($options as $option) {
                $sql = "INSERT INTO poll_options (poll_id, option_text) VALUES ('$poll_id', '$option')";
                $conn->query($sql);
            }

            echo "<div class='alert alert-success'>Poll created successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please provide a question and at least two options.</div>";
    }
}

// Fetch active polls created by the user
$pollsSql = "SELECT * FROM polls WHERE id='$user_id' AND end_date >= CURDATE()";
$pollsResult = $conn->query($pollsSql);

// Check if the query was successful
if ($pollsResult === false) {
    die("Error fetching polls: " . $conn->error); // Display the SQL error if any
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px 0;
            background-color: white;
        }

        .section h3 {
            margin-bottom: 15px;
        }

        /* Sidebar Styling */
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
            padding: 10px;
            border-bottom: 1px solid #324c65;
        }

        .menu-item:hover {
            background-color: #1a2c41;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>User Dashboard</h4>
        <a href="welcome.php" class="menu-item">Profile</a>
        <a href="poll_management.php" class="menu-item">Poll Management</a>
        <a href="poll_results.php" class="menu-item">Poll Results</a>
        <a href="notifications.php" class="menu-item">Notifications</a>
        <a href="user_analytics.php" class="menu-item">User Analytics</a>
        <a href="vote.php" class="menu-item">Vote</a> <!-- New vote button -->
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Poll Management</h2>

        <!-- Create New Poll Section -->
        <div class="section">
            <h3>Create a New Poll</h3>
            <form method="POST" action="">

                <!-- Poll Start and End Date Section -->
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Sports">Sports</option>
                        <option value="Politics">Politics</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Technology">Technology</option>
                        <option value="Custom">Custom Category</option>
                    </select>
                </div>

                <!-- Poll Question -->
                <div class="mb-3">
                    <label for="poll_question" class="form-label">Poll Question:</label>
                    <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                </div>

                <!-- Poll Type -->
                <div class="mb-3">
                    <label for="poll_type" class="form-label">Poll Type:</label>
                    <select class="form-control" id="poll_type" name="poll_type" required>
                        <option value="mcq">MCQ (Multiple Choice)</option>
                        <option value="checklist">Checklist</option>
                        <option value="yes_no">Yes/No</option>
                        <option value="rating">Rating</option>
                    </select>
                </div>

                <!-- Poll Options -->
                <div class="mb-3">
                    <label for="option1" class="form-label">Option 1:</label>
                    <input type="text" class="form-control" id="option1" name="options[]" required>
                </div>
                <div class="mb-3">
                    <label for="option2" class="form-label">Option 2:</label>
                    <input type="text" class="form-control" id="option2" name="options[]" required>
                </div>
                <div class="mb-3">
                    <label for="option3" class="form-label">Option 3 (Optional):</label>
                    <input type="text" class="form-control" id="option3" name="options[]">
                </div>
                <div class="mb-3">
                    <label for="option4" class="form-label">Option 4 (Optional):</label>
                    <input type="text" class="form-control" id="option4" name="options[]">
                </div>

                <button type="submit" name="submit_poll" class="btn btn-primary">Create Poll</button>
            </form>
        </div>

        <!-- View Your Polls Section -->
        <div class="section">
            <h3>Your Active Polls</h3>
            <?php if ($pollsResult->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Poll Question</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($poll = $pollsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($poll['question']); ?></td>
                                <td><?php echo htmlspecialchars($poll['category']); ?></td>
                                <td><?php echo htmlspecialchars($poll['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($poll['end_date']); ?></td>
                                <td>
                                    <a href="edit_poll.php?id=<?php echo $poll['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_poll.php?id=<?php echo $poll['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    <a href="view_poll_results.php?id=<?php echo $poll['id']; ?>" class="btn btn-info btn-sm">View Results</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You haven't created any active polls yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
