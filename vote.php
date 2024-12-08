<?php
include 'connection.php';

if (!isset($_SESSION['id'])) {
    echo "You must log in to vote.";
    exit;
}

// Fetch active polls with creator names
$pollsSql = "SELECT polls.*, prayojan.name as creator_name 
             FROM polls 
             JOIN prayojan ON polls.user_id = prayojan.id 
             WHERE end_date >= CURDATE()";
$pollsResult = $conn->query($pollsSql);

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_vote'])) {
    $poll_id = $_POST['poll_id'];
    $selected_option = $_POST['option'];
    $user_id = $_SESSION['id'];

    // Check if the user is the creator of the poll
    $pollCreatorSql = "SELECT user_id FROM polls WHERE id='$poll_id'";
    $creatorResult = $conn->query($pollCreatorSql);

    if ($creatorResult->num_rows > 0) {
        $poll = $creatorResult->fetch_assoc();
        if ($poll['user_id'] == $user_id) {
            echo "<script>alert('You cannot vote since you created this poll.');</script>";
            echo "<script>window.history.back();</script>";
            exit;
        }
    }

    // Check if the user has already voted in this poll
    $checkVoteSql = "SELECT * FROM votes WHERE user_id='$user_id' AND poll_id='$poll_id'";
    $voteResult = $conn->query($checkVoteSql);

    if ($voteResult->num_rows == 0) {
        $insertVoteSql = "INSERT INTO votes (user_id, poll_id, option_id) VALUES ('$user_id', '$poll_id', '$selected_option')";
        
        if ($conn->query($insertVoteSql) === TRUE) {
            $updateOptionSql = "UPDATE poll_options SET votes = votes + 1 WHERE id = '$selected_option'";
            $conn->query($updateOptionSql);
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
    $user_id = $_SESSION['id'];

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
        .icon-container {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        .dropdown-menu {
            font-size: 0.9rem;
        }
        .modal-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
        }
        #qrCodeContainer {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <h2 class="mt-5">Vote on Poll</h2>
        <?php if ($pollsResult->num_rows > 0): ?>
            <div class="poll-container">
                <?php while ($poll = $pollsResult->fetch_assoc()): ?>
                    <div class="poll-card">
                        <div class="icon-container">
                            <!-- Report and Share Dropdown -->
                            <button class="btn btn-secondary" onclick="reportPoll(<?php echo $poll['id']; ?>)">Report</button>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="shareMenu<?php echo $poll['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Share
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="shareMenu<?php echo $poll['id']; ?>">
                                    <li><a class="dropdown-item" href="#" onclick="copyLink('<?php echo "http://localhost/onlinepollingsystem/view_poll.php?link=" . $poll['unique_link']; ?>')">Copy Link</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="showQRModal('<?php echo "http://localhost/onlinepollingsystem/view_poll.php?link=" . $poll['unique_link']; ?>')">Generate QR Code</a></li>
                                </ul>
                            </div>
                        </div>
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
                                <button type="submit" name="submit_vote" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No active polls available for voting.</div>
        <?php endif; ?>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="qrCodeContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function copyLink(link) {
            navigator.clipboard.writeText(link).then(() => {
                alert("Poll link copied to clipboard!");
            }).catch(err => {
                alert("Failed to copy link: " + err);
            });
        }

        function reportPoll(pollId) {
            if (confirm("Do you want to report this poll?")) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "vote.php";

                const pollInput = document.createElement("input");
                pollInput.type = "hidden";
                pollInput.name = "poll_id";
                pollInput.value = pollId;

                const reportInput = document.createElement("input");
                reportInput.type = "hidden";
                reportInput.name = "report_poll";
                reportInput.value = "true";

                form.appendChild(pollInput);
                form.appendChild(reportInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function showQRModal(link) {
            const qrContainer = document.getElementById("qrCodeContainer");
            qrContainer.innerHTML = ""; // Clear previous QR code
            new QRCode(qrContainer, {
                text: link,
                width: 200,
                height: 200,
                colorDark: "#000",
                colorLight: "#fff",
                correctLevel: QRCode.CorrectLevel.H
            });
            const qrModal = new bootstrap.Modal(document.getElementById("qrModal"));
            qrModal.show();
        }
    </script>
</body>
</html>
