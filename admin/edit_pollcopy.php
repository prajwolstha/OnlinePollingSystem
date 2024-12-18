<?php
// Include necessary files
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php';

// Check if poll ID is provided
if (!isset($_GET['poll_id'])) {
    echo "Poll ID is missing.";
    exit;
}

// Fetch poll details
$poll_id = intval($_GET['poll_id']);
$pollQuery = $conn->query("SELECT * FROM polls WHERE id = $poll_id");
$poll = $pollQuery->fetch_assoc();

if (!$poll) {
    echo "Poll not found.";
    exit;
}

// Fetch poll options
$optionsQuery = $conn->query("SELECT * FROM poll_options WHERE poll_id = $poll_id");
$options = [];
while ($row = $optionsQuery->fetch_assoc()) {
    $options[] = $row;
}

// Update poll logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $conn->real_escape_string($_POST['question']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $options = $_POST['options'];

    // Update poll
    $conn->query("UPDATE polls SET question = '$question', end_date = '$end_date' WHERE id = $poll_id");

    // Update options
    foreach ($options as $option_id => $option_value) {
        $conn->query("UPDATE poll_options SET option_text = '$option_value' WHERE id = $option_id");
    }

    echo "<script>alert('Poll updated successfully.'); window.location.href='manage_polls.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .main-container {
            display: flex;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
        }

        .form-control {
            margin-bottom: 15px;
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
        <h1>Edit Poll</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="question" class="form-label">Poll Question</label>
                <input type="text" name="question" id="question" class="form-control" value="<?php echo htmlspecialchars($poll['question']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($poll['end_date']); ?>" required>
            </div>
            <h5>Poll Options</h5>
            <?php foreach ($options as $option): ?>
                <div class="mb-3">
                    <input type="text" name="options[<?php echo $option['id']; ?>]" class="form-control" value="<?php echo htmlspecialchars($option['option_text']); ?>" required>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Update Poll</button>
        </form>
    </div>
</div>
</body>
</html>
