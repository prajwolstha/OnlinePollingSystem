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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .section h3 {
            margin-bottom: 15px;
        }

        /* Add styles for the poll types section */
        .poll-types {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .poll-type {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            cursor: pointer;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .poll-type:hover {
            background-color: #e0e0e0;
        }

        .poll-type img {
            width: 50px;
            height: 50px;
        }

        .poll-type span {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
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
                <span class="verified"><img src="verified.png" alt="img"></span>
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

                <div class="poll-types">
                    <div class="poll-type" onclick="scrollToSection('mcq')">
                        <img src="icons/mcq_icon.png" alt="Multiple Choice">
                        <span>Multiple Choice</span>
                    </div>
                    <div class="poll-type" onclick="scrollToSection('word_cloud')">
                        <img src="icons/word_cloud_icon.png" alt="Word Cloud">
                        <span>Word Cloud</span>
                    </div>
                    <div class="poll-type" onclick="scrollToSection('quiz')">
                        <img src="icons/quiz_icon.png" alt="Quiz">
                        <span>Quiz</span>
                    </div>
                    <div class="poll-type" onclick="scrollToSection('rating')">
                        <img src="icons/rating_icon.png" alt="Rating">
                        <span>Rating</span>
                    </div>
                    <div class="poll-type" onclick="scrollToSection('open_text')">
                        <img src="icons/open_text_icon.png" alt="Open Text">
                        <span>Open Text</span>
                    </div>
                    <div class="poll-type" onclick="scrollToSection('ranking')">
                        <img src="icons/ranking_icon.png" alt="Ranking">
                        <span>Ranking</span>
                    </div>
                </div>

                <!-- Template will appear here based on selection -->
                <div id="poll-template" class="section mt-4"></div>

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

    <script>
        // Function to load poll template based on selection and scroll down
        function scrollToSection(type) {
            const pollTemplate = document.getElementById('poll-template');
            let templateHTML = '';

            if (type === 'mcq') {
                templateHTML = `
                    <h4>Create Multiple Choice Poll</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="poll_question" class="form-label">Poll Question:</label>
                            <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                        </div>
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
                `;
            } else if (type === 'word_cloud') {
                templateHTML = `
                    <h4>Create Word Cloud Poll</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="poll_question" class="form-label">Poll Question:</label>
                            <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                        </div>
                        <div class="mb-3">
                            <label for="word_limit" class="form-label">Word Limit:</label>
                            <input type="number" class="form-control" id="word_limit" name="word_limit" required>
                        </div>
                        <button type="submit" name="submit_poll" class="btn btn-primary">Create Poll</button>
                    </form>
                `;
            } else if (type === 'quiz') {
                templateHTML = `
                    <h4>Create Quiz</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="quiz_question" class="form-label">Quiz Question:</label>
                            <input type="text" class="form-control" id="quiz_question" name="quiz_question" required>
                        </div>
                        <div class="mb-3">
                            <label for="correct_answer" class="form-label">Correct Answer:</label>
                            <input type="text" class="form-control" id="correct_answer" name="correct_answer" required>
                        </div>
                        <button type="submit" name="submit_poll" class="btn btn-primary">Create Quiz</button>
                    </form>
                `;
            } else if (type === 'rating') {
                templateHTML = `
                    <h4>Create Rating Poll</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="poll_question" class="form-label">Poll Question:</label>
                            <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_rating" class="form-label">Max Rating:</label>
                            <input type="number" class="form-control" id="max_rating" name="max_rating" required>
                        </div>
                        <button type="submit" name="submit_poll" class="btn btn-primary">Create Rating Poll</button>
                    </form>
                `;
            } else if (type === 'open_text') {
                templateHTML = `
                    <h4>Create Open Text Poll</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="poll_question" class="form-label">Poll Question:</label>
                            <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                        </div>
                        <div class="mb-3">
                            <label for="character_limit" class="form-label">Character Limit:</label>
                            <input type="number" class="form-control" id="character_limit" name="character_limit" required>
                        </div>
                        <button type="submit" name="submit_poll" class="btn btn-primary">Create Open Text Poll</button>
                    </form>
                `;
            } else if (type === 'ranking') {
                templateHTML = `
                    <h4>Create Ranking Poll</h4>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="poll_question" class="form-label">Poll Question:</label>
                            <input type="text" class="form-control" id="poll_question" name="poll_question" required>
                        </div>
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
                        <button type="submit" name="submit_poll" class="btn btn-primary">Create Ranking Poll</button>
                    </form>
                `;
            }

            // Load the template and scroll down to it
            pollTemplate.innerHTML = templateHTML;
            pollTemplate.scrollIntoView({ behavior: 'smooth' });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
