<?php


// Database connection
include 'connection.php';

// Fetch all categories for the sidebar
$category_query = "SELECT DISTINCT category FROM polls";
$category_result = $conn->query($category_query);

// Get selected category from URL (if any)
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch all active polls with optional category filtering
$query = "SELECT polls.id, polls.question, polls.start_date, polls.end_date, polls.category, polls.created_at,
                 (SELECT COUNT(votes.id) FROM votes WHERE votes.poll_id = polls.id) AS total_votes
          FROM polls
          WHERE start_date <= CURDATE() AND end_date >= CURDATE()";
if ($selected_category) {
    $query .= " AND category = '" . $conn->real_escape_string($selected_category) . "'";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Polls - Guest Access</title>
    <!-- MDBootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="favicon.png">


    <style>
        /* Styles for the Login button */
        .login-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #2ba5e8;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: 1px solid #2ba5e8;
            transition: background-color 0.3s ease, color 0.3s ease, border 0.3s ease;
        }

        .login-button:hover {
            background-color: transparent;
            color: #2ba5e8;
            border: 1px solid #2ba5e8;
        }

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            width: 200px;
            height: calc(100vh - 80px);
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar a {
            display: block;
            color: #333;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #2ba5e8;
            color: #fff;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .badge {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- "Login to Vote" button -->
    <a href="login.php" class="login-button">Login to Vote</a>

    <!-- Sidebar for Categories -->
    <div class="sidebar">
        <h4>Categories</h4>
        <a href="guest.php" class="<?= !$selected_category ? 'active' : '' ?>">All</a>
        <?php while ($category = $category_result->fetch_assoc()): ?>
            <a href="guest.php?category=<?= urlencode($category['category']) ?>" 
               class="<?= $selected_category === $category['category'] ? 'active' : '' ?>">
               <?= htmlspecialchars($category['category']) ?>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- Main Content -->
    <div class="main-content container mt-5">
        <h2 class="text-center">Current Polls</h2>
        <hr>

        <!-- Display polls -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($poll = $result->fetch_assoc()): ?>
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($poll['question']); ?></h5>
                        <p class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($poll['category']); ?></p>
                        <p class="card-text"><strong>Total Votes:</strong> <?php echo $poll['total_votes']; ?></p>
                        <p class="card-text"><strong>Ends on:</strong> <?php echo htmlspecialchars($poll['end_date']); ?></p>

                        <!-- Fetch poll options -->
                        <?php
                        $poll_id = $poll['id'];
                        $options_query = "SELECT option_text, votes FROM poll_options WHERE poll_id = $poll_id";
                        $options_result = $conn->query($options_query);
                        ?>
                        <ul class="list-group">
                            <?php while ($option = $options_result->fetch_assoc()): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($option['option_text']); ?>
                                    <span class="badge bg-primary rounded-pill"><?php echo $option['votes']; ?></span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No current polls available.</p>
        <?php endif; ?>
    </div>

    <!-- MDBootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
</body>
</html>
