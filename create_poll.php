<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'poll');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the poll question and options from the form
    $question = $_POST['question'];
    $options = array_filter($_POST['options']); // Remove empty options

    // Insert poll into the polls table
    $sql = "INSERT INTO polls (question) VALUES ('$question')";
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <div class="container">
        <h2 class="mt-5">Create a New Poll</h2>
        <form action="create_poll.php" method="POST">
            <div class="mb-3">
                <label for="question" class="form-label">Poll Question</label>
                <input type="text" class="form-control" id="question" name="question" required>
            </div>

            <div class="mb-3">
                <label for="option1" class="form-label">Option 1</label>
                <input type="text" class="form-control" id="option1" name="options[]" required>
            </div>
            <div class="mb-3">
                <label for="option2" class="form-label">Option 2</label>
                <input type="text" class="form-control" id="option2" name="options[]" required>
            </div>
            <div class="mb-3">
                <label for="option3" class="form-label">Option 3 (Optional)</label>
                <input type="text" class="form-control" id="option3" name="options[]">
            </div>
            <div class="mb-3">
                <label for="option4" class="form-label">Option 4 (Optional)</label>
                <input type="text" class="form-control" id="option4" name="options[]">
            </div>

            <button type="submit" class="btn btn-primary">Create Poll</button>
        </form>
    </div>




    <div class="container mt-5">
        <a href="create_poll_form.php" class="btn btn-primary">Back to Create Poll Form</a>
    </div>



</body>
</html>
