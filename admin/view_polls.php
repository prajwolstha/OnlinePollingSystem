<?php
include '../includes/header.php';
include '../includes/sidebar.php';
include '../connection.php';

// Fetch polls logic
$sql = "SELECT * FROM polls";
$polls = $conn->query($sql);
?>
<div class="main-content">
    <h1>View Polls</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Poll Question</th>
                <th>Votes</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($poll = $polls->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($poll['question']); ?></td>
                    <td><?php echo $poll['votes']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
