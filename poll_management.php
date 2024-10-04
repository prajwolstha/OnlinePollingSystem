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
$verified = $user['verified']; // Fetch the verified status

// Handle poll creation (for verified users only)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_poll'])) {
    if ($verified == 1) {
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
    } else {
        echo "<div class='alert alert-warning'>You need to be verified to create a poll. Please submit your documents for verification.</div>";
    }
}

// Handle verification document upload for non-verified users
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_verification'])) {
    $passportDoc = $_FILES['passport_doc'];
    $passportPhoto = $_FILES['passport_photo'];

    // Ensure the upload directory exists
    $uploadDir = 'uploads/verification_docs/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory with appropriate permissions
    }

    // Define paths for uploaded files
    $passportDocPath = $uploadDir . basename($passportDoc['name']);
    $passportPhotoPath = $uploadDir . basename($passportPhoto['name']);

    // Move uploaded files to the destination directory
    if (move_uploaded_file($passportDoc['tmp_name'], $passportDocPath) && move_uploaded_file($passportPhoto['tmp_name'], $passportPhotoPath)) {
        // Insert document details into verification_documents table
        $sql = "INSERT INTO verification_documents (user_id, document, photo, status) 
                VALUES ('$user_id', '$passportDocPath', '$passportPhotoPath', 'pending')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Documents uploaded successfully. Please wait for verification.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error saving documents in the database: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error uploading documents. Please try again.</div>";
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
        /* Styling for the sidebar and content */
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

        /* Profile Picture */
        .profile-pic {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center">
            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
            <h4><?php echo htmlspecialchars($user['name']); ?></h4>
            <?php if ($user['verified']): ?>
                <span class="verified">Verified</span>
            <?php endif; ?>
        </div>
        <!-- Sidebar Menu -->
        <div class="menu">
            <a href="welcome.php" class="menu-item">Profile</a>
            <a href="poll_management.php" class="menu-item menu-item-active">Poll Management</a>
            <a href="poll_results.php" class="menu-item">Poll Results</a>
            <a href="notifications.php" class="menu-item">Notifications</a>
            <a href="user_analytics.php" class="menu-item">User Analytics</a>
            <a href="vote.php" class="menu-item">Vote</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Poll Management</h2>

        <?php if ($verified == 1): ?>
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
        <?php else: ?>
            <!-- Verification Form for Non-Verified Users -->
            <div class="section">
                <h3>Verify Your Account</h3>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="passport_doc" class="form-label">Upload Passport/Citizen Document:</label>
                        <input type="file" class="form-control" id="passport_doc" name="passport_doc" required>
                    </div>
                    <div class="mb-3">
                        <label for="passport_photo" class="form-label">Upload Passport Size Photo:</label>
                        <input type="file" class="form-control" id="passport_photo" name="passport_photo" required>
                    </div>
                    <button type="submit" name="submit_verification" class="btn btn-primary">Submit for Verification</button>
                </form>
            </div>
        <?php endif; ?>

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
