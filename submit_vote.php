<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $poll_id = $_POST['poll_id'];
    $option_id = $_POST['option_id'];

    // Insert vote into the database
    $sql = "INSERT INTO votes (poll_id, option_id, created_at) VALUES ('$poll_id', '$option_id', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Thank you for voting!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
} else {
    die("Invalid request.");
}
?>
