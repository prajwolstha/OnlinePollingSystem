<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

// Fetch all polls
$sql = "SELECT * FROM polls";
$polls = $conn->query($sql);

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
    <div class="container mt-5">
        <h2>Poll Results</h2>

        <?php while ($poll = $polls->fetch_assoc()): ?>
            <div class="section mb-4">
                <h4><?php echo htmlspecialchars($poll['question']); ?></h4>

                <!-- Fetch options and votes for the current poll -->
                <?php
                $poll_id = $poll['id'];
                $options_sql = "SELECT * FROM poll_options WHERE poll_id = $poll_id";
                $options = $conn->query($options_sql);
                ?>

                <ul class="list-group">
                    <?php while ($option = $options->fetch_assoc()): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($option['option_text']); ?> 
                            <span class="badge bg-primary"><?php echo $option['votes']; ?> votes</span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
