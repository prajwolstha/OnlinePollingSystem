<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Ensure the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $poll_id = $_POST['poll_id'];
    $option_id = $_POST['option_id'];

    // Increment the vote count for the selected option
    $sql = "UPDATE poll_options SET votes = votes + 1 WHERE id = $option_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Your vote has been successfully submitted!</div>";
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
    <title>Vote Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="polls.php" class="btn btn-primary">Back to Polls</a>
    </div>
</body>
</html>
