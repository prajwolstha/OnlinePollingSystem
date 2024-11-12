<?php
include 'connection.php';
// Fetch active polls
$pollsSql = "SELECT * FROM polls WHERE end_date >= CURDATE()";
$pollsResult = $conn->query($pollsSql);

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_vote'])) {
    $poll_id = $_POST['poll_id'];
    $selected_option = $_POST['option'];
    $user_id = $_SESSION['id']; // Assuming user_id is stored in session when logged in

    // Check if the user has already voted in this poll
    $checkVoteSql = "SELECT * FROM votes WHERE user_id='$user_id' AND poll_id='$poll_id'";
    $voteResult = $conn->query($checkVoteSql);

    if ($voteResult->num_rows == 0) {
        // Insert vote into the `votes` table
        $insertVoteSql = "INSERT INTO votes (user_id, poll_id, option_id) VALUES ('$user_id', '$poll_id', '$selected_option')";
        
        if ($conn->query($insertVoteSql) === TRUE) {
            // Update the `poll_options` table to increment the vote count
            $updateOptionSql = "UPDATE poll_options SET votes = votes + 1 WHERE id = '$selected_option'";
            $conn->query($updateOptionSql); // Execute the update query

            echo "<div class='alert alert-success'>Vote submitted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error submitting vote: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>You have already voted in this poll.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote on Poll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            margin-left: 270px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Vote on Poll</h2>
        <?php if ($pollsResult->num_rows > 0): ?>
            <?php while ($poll = $pollsResult->fetch_assoc()): ?>
                <div class="mb-4">
                    <h5><?php echo htmlspecialchars($poll['question']); ?></h5>
                    <?php
                    $optionsSql = "SELECT * FROM poll_options WHERE poll_id=" . $poll['id'];
                    $optionsResult = $conn->query($optionsSql);
                    ?>
                    <form method="POST" action="vote.php">
                        <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                        <?php while ($option = $optionsResult->fetch_assoc()): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option" id="option<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" required>
                                <label class="form-check-label" for="option<?php echo $option['id']; ?>">
                                    <?php echo htmlspecialchars($option['option_text']); ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
                        <button type="submit" name="submit_vote" class="btn btn-primary mt-3">Submit Vote</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">No active polls available for voting.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>