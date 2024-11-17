<?php
include 'connection.php';
// Fetch active polls with creator names
$pollsSql = "SELECT polls.*, prayojan.name as creator_name FROM polls JOIN prayojan ON polls.user_id = prayojan.id WHERE end_date >= CURDATE()";
$pollsResult = $conn->query($pollsSql);

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_vote'])) {
    $poll_id = $_POST['poll_id'];
    $selected_option = $_POST['option'];
    $user_id = $_SESSION['id']; // Assuming user_id is stored in session when logged in

    // Check if the user has already voted in this poll
    $checkVoteSql = "SELECT * FROM votes WHERE user_id='$user_id' AND poll_id='$poll_id'";
    $voteResult = $conn->query($checkVoteSql);

    if ($voteResult->num_rows == 0) {
        // Insert vote into the `votes` table
        $insertVoteSql = "INSERT INTO votes (user_id, poll_id, option_id) VALUES ('$user_id', '$poll_id', '$selected_option')";
        
        if ($conn->query($insertVoteSql) === TRUE) {
            // Update the `poll_options` table to increment the vote count
            $updateOptionSql = "UPDATE poll_options SET votes = votes + 1 WHERE id = '$selected_option'";
            $conn->query($updateOptionSql); // Execute the update query

            echo "<div class='alert alert-success'>Vote submitted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error submitting vote: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>You have already voted in this poll.</div>";
    }
}

// Handle report submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['report_poll'])) {
    $poll_id = $_POST['poll_id'];
    $user_id = $_SESSION['id']; // Assuming user_id is stored in session when logged in

    // Insert report into the `notifications` table for admin to review
    $reportSql = "INSERT INTO notifications (poll_id, user_id, message, is_read) VALUES ('$poll_id', '$user_id', 'User reported poll ID $poll_id.', FALSE)";
    
    if ($conn->query($reportSql) === TRUE) {
        echo "<div class='alert alert-success'>Report submitted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error submitting report: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote on Poll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .poll-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .poll-card {
            width: calc(50% - 10px);
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            min-height: 300px;
        }
        .poll-card h5 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .poll-creator {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 10px;
        }
        .form-check {
            margin-bottom: 10px;
        }
        .btn-submit {
            background-color: #0B1042;
            color: #fff;
            border: none;
            padding: 5px 15px;
            font-weight: bold;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #1a237e;
        }
        .btn-clear, .btn-report {
            color: #6c757d;
            background: transparent;
            border: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-clear:hover, .btn-report:hover {
            color: #333;
        }
    </style>
</head>
<body>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mt-5">Vote on Poll</h2>
        <?php if ($pollsResult->num_rows > 0): ?>
            <div class="poll-container">
                <?php while ($poll = $pollsResult->fetch_assoc()): ?>
                    <div class="poll-card">
                        <div class="poll-creator">Created by: <?php echo htmlspecialchars($poll['creator_name']); ?></div>
                        <h5><?php echo htmlspecialchars($poll['question']); ?></h5>
                        <?php
                        $optionsSql = "SELECT * FROM poll_options WHERE poll_id=" . $poll['id'];
                        $optionsResult = $conn->query($optionsSql);
                        ?>
                        <form method="POST" action="vote.php">
                            <input type="hidden" name="poll_id" value="<?php echo $poll['id']; ?>">
                            <?php while ($option = $optionsResult->fetch_assoc()): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="option" id="option<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" required>
                                    <label class="form-check-label" for="option<?php echo $option['id']; ?>">
                                        <?php echo htmlspecialchars($option['option_text']); ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" name="submit_vote" class="btn btn-submit">Submit</button>
                                <button type="button" class="btn-clear" onclick="clearSelection(<?php echo $poll['id']; ?>)">Clear</button>
                            </div>
                            <button type="button" class="btn-report mt-2" onclick="reportPoll(<?php echo $poll['id']; ?>)">Report</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No active polls available for voting.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to clear the selected option
        function clearSelection(pollId) {
            const radioButtons = document.querySelectorAll(`input[name="option"]`);
            radioButtons.forEach(radio => {
                if (radio.closest('form').querySelector(`input[name="poll_id"]`).value == pollId) {
                    radio.checked = false;
                }
            });
        }

        // Function to confirm and submit a report
        function reportPoll(pollId) {
            const confirmReport = confirm("Do you want to report this poll?");
            if (confirmReport) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "vote.php";

                const inputPollId = document.createElement("input");
                inputPollId.type = "hidden";
                inputPollId.name = "poll_id";
                inputPollId.value = pollId;

                const inputReport = document.createElement("input");
                inputReport.type = "hidden";
                inputReport.name = "report_poll";
                inputReport.value = true;

                form.appendChild(inputPollId);
                form.appendChild(inputReport);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
