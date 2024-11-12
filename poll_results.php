<?php
include 'connection.php';
// Fetch user details
$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error); // Display SQL error if any
}

$user = $result->fetch_assoc();
$profile_pic = $user['profile_pic'] ?? 'uploads/default_profile.png'; // Fallback to default profile picture

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
    <style>
    
        .content {
            margin-left: 270px;
            padding: 20px;
        }


        .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px 0;
            background-color: white;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>
   
    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Poll Results</h2>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
