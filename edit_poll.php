<?php
include 'connection.php';
// Fetch poll details
$poll_id = $_GET['id'];
$sql = "SELECT * FROM polls WHERE id='$poll_id'";
$pollResult = $conn->query($sql);
$poll = $pollResult->fetch_assoc();

// Handle poll update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $poll_question = $_POST['poll_question'];
    $options = array_filter($_POST['options']); // Remove empty options

    if (!empty($poll_question) && count($options) > 1) {
        // Update poll
        $sql = "UPDATE polls SET question='$poll_question' WHERE id='$poll_id'";
        $conn->query($sql);

        // Delete old options
        $conn->query("DELETE FROM poll_options WHERE poll_id='$poll_id'");

        // Insert new options
        foreach ($options as $option) {
            $sql = "INSERT INTO poll_options (poll_id, option_text) VALUES ('$poll_id', '$option')";
            $conn->query($sql);
        }

        header("Location: index.php");
        exit();
        } else {
        echo "<div class='alert alert-danger'>Please provide a question and at least two options.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Edit Poll</h2>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="poll_question" class="form-label">Poll Question:</label>
                <input type="text" class="form-control" id="poll_question" name="poll_question" value="<?php echo htmlspecialchars($poll['question']); ?>" required>
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

            <button type="submit" class="btn btn-primary">Update Poll</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
