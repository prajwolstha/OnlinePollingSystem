<?php
include 'connection.php';

// Get the unique link from the query parameter
$unique_link = $_GET['link'] ?? '';

// Check if the link is provided
if (empty($unique_link)) {
    echo "Poll not found.";
    exit;
}

// Fetch the poll details using the unique link
$sql = "SELECT * FROM polls WHERE unique_link = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $unique_link);
$stmt->execute();
$result = $stmt->get_result();

// Check if the poll exists
if ($result->num_rows === 0) {
    echo "Poll not found.";
    exit;
}

// Fetch poll data
$poll = $result->fetch_assoc();

// Fetch poll options
$optionsSql = "SELECT * FROM poll_options WHERE poll_id = ?";
$stmt = $conn->prepare($optionsSql);
$stmt->bind_param("i", $poll['id']);
$stmt->execute();
$optionsResult = $stmt->get_result();

// Check login state
$is_logged_in = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($poll['question']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            padding: 20px;
        }
        .poll-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .poll-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
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
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #1a237e;
        }
        .login-prompt {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        .login-prompt a {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .login-prompt a:hover {
            text-decoration: underline;
        }
        /* Popup Styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        .popup-header {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.2rem;
            color: #333;
        }
        .popup-close:hover {
            color: #000;
        }
        .popup-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }
    </style>
</head>
<body>
    <div class="poll-container">
        <h2><?php echo htmlspecialchars($poll['question']); ?></h2>
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
            <?php if ($is_logged_in): ?>
                <button type="submit" name="submit_vote" class="btn btn-submit mt-3">Submit Vote</button>
            <?php else: ?>
                <div class="login-prompt">
                    <a id="loginPopupLink">Login</a> to submit your vote.
                </div>
            <?php endif; ?>
        </form>
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Back to Index</a>
        </div>
    </div>

    <!-- Login Popup -->
    <div class="popup-backdrop" id="popupBackdrop"></div>
    <div class="popup" id="loginPopup">
        <div class="popup-close" id="popupClose">&times;</div>
        <div class="popup-header">Login</div>
        <form action="login_handler.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script>
        const loginPopupLink = document.getElementById('loginPopupLink');
        const loginPopup = document.getElementById('loginPopup');
        const popupBackdrop = document.getElementById('popupBackdrop');
        const popupClose = document.getElementById('popupClose');

        loginPopupLink.addEventListener('click', () => {
            loginPopup.style.display = 'block';
            popupBackdrop.style.display = 'block';
        });

        popupClose.addEventListener('click', () => {
            loginPopup.style.display = 'none';
            popupBackdrop.style.display = 'none';
        });

        popupBackdrop.addEventListener('click', () => {
            loginPopup.style.display = 'none';
            popupBackdrop.style.display = 'none';
        });
    </script>
</body>
</html>
