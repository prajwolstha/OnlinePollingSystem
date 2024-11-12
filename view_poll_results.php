<?php
include 'connection.php';
// Check if poll ID is provided
if (!isset($_GET['id'])) {
    die("Error: Poll ID is missing.");
}

$poll_id = $_GET['id'];

// Fetch poll details
$sql = "SELECT * FROM polls WHERE id='$poll_id'";
$pollResult = $conn->query($sql);

if (!$pollResult || $pollResult->num_rows == 0) {
    die("Error fetching poll details: " . $conn->error);
}

$poll = $pollResult->fetch_assoc();

// Fetch poll options and vote counts
$optionsSql = "SELECT option_text, COUNT(votes.id) as vote_count 
               FROM poll_options 
               LEFT JOIN votes ON poll_options.id = votes.option_id 
               WHERE poll_options.poll_id='$poll_id' 
               GROUP BY poll_options.id";
$optionsResult = $conn->query($optionsSql);

if (!$optionsResult) {
    die("Error fetching poll options: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Poll Results for "<?php echo htmlspecialchars($poll['question']); ?>"</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Vote Count</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($option = $optionsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($option['option_text']); ?></td>
                        <td><?php echo htmlspecialchars($option['vote_count']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
