<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all active polls (that the user has not voted on)
$sql = "SELECT polls.id, polls.question, polls.category, polls.start_date, polls.end_date 
        FROM polls 
        WHERE polls.end_date >= CURDATE()";
$pollsResult = $conn->query($sql);

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
    <title>Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Available Polls</h2>
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
                                <a href="vote_on_poll.php?poll_id=<?php echo $poll['id']; ?>" class="btn btn-primary btn-sm">Vote</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No active polls available to vote on.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
