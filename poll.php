<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'poll');

// Fetch all polls
$polls = $conn->query("SELECT * FROM polls");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Polls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Available Polls</h2>

        <?php while ($poll = $polls->fetch_assoc()): ?>
            <div class="section mb-5">
                <h4><?php echo $poll['question']; ?></h4>

                <!-- Fetch options for the poll -->
                <?php
                $poll_id = $poll['id'];
                $options = $conn->query("SELECT * FROM poll_options WHERE poll_id = $poll_id");
                ?>

                <form action="vote.php" method="POST">
                    <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                    <?php while ($option = $options->fetch_assoc()): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option_id" value="<?php echo $option['id']; ?>" required>
                            <label class="form-check-label"><?php echo $option['option_text']; ?></label>
                        </div>
                    <?php endwhile; ?>

                    <button type="submit" class="btn btn-primary mt-3">Vote</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
