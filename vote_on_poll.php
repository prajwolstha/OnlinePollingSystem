<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch poll ID
$poll_id = $_GET['poll_id'];

// Fetch poll options
$sql = "SELECT * FROM poll_options WHERE poll_id='$poll_id'";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching poll options: " . $conn->error);
}

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_vote'])) {
    $selected_option = $_POST['option'];
    $user_id = $_SESSION['id'];  // Use 'id' because that's the correct key in the session

    // Check if the user has already voted in this poll
    $checkVoteSql = "SELECT * FROM votes WHERE user_id='$user_id' AND poll_id='$poll_id'";
    $voteResult = $conn->query($checkVoteSql);

    if ($voteResult->num_rows == 0) {
        // Insert vote
        $insertVoteSql = "INSERT INTO votes (user_id, poll_id, option_id) VALUES ('$user_id', '$poll_id', '$selected_option')";
        if ($conn->query($insertVoteSql) === TRUE) {
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
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Vote on Poll</h2>
        <form method="POST" action="">
            <?php while ($option = $result->fetch_assoc()): ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
