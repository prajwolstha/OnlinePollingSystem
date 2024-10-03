<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'poll');

$email = $_SESSION['email'];
$sql = "SELECT * FROM prayojan WHERE email='$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$verified = $user['verified'];

// If the user submits verification documents
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_verification'])) {
    $userId = $user['id'];
    $documentPath = '';
    $photoPath = '';

    // Ensure the 'uploads' directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Check and upload the passport-size photo
    if (!empty($_FILES['passport_photo']['name'])) {
        $photoPath = 'uploads/' . basename($_FILES['passport_photo']['name']);
        if (!move_uploaded_file($_FILES['passport_photo']['tmp_name'], $photoPath)) {
            echo "<div class='alert alert-danger'>Failed to upload passport photo.</div>";
        }
    }

    // Check and upload the ID document
    if (!empty($_FILES['id_document']['name'])) {
        $documentPath = 'uploads/' . basename($_FILES['id_document']['name']);
        if (!move_uploaded_file($_FILES['id_document']['tmp_name'], $documentPath)) {
            echo "<div class='alert alert-danger'>Failed to upload ID document.</div>";
        }
    }

    // Insert into verification_documents table
    if ($photoPath && $documentPath) {
        $sql = "INSERT INTO verification_documents (user_id, document, photo, status) 
                VALUES ('$userId', '$documentPath', '$photoPath', 'pending')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Documents submitted for verification.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please upload both passport photo and ID document.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 15px 0;
            background-color: #f8f9fa;
        }

        .section h3 {
            margin-bottom: 15px;
        }

        .btn-create-poll {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Welcome, <?php echo htmlspecialchars($email); ?></h2>
        
        <!-- Verification Status Section -->
        <div class="section">
            <h3>Verification Status</h3>
            <?php if ($verified): ?>
                <div class="alert alert-success">You are verified and can create polls.</div>
            <?php else: ?>
                <div class="alert alert-warning">You are not verified. You can only vote on existing polls.</div>
                
                <!-- Document Upload Form -->
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="passport_photo" class="form-label">Upload Passport-size Photo:</label>
                        <input type="file" class="form-control" id="passport_photo" name="passport_photo" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_document" class="form-label">Upload ID Document (Citizenship/Passport):</label>
                        <input type="file" class="form-control" id="id_document" name="id_document" required>
                    </div>
                    <button type="submit" name="submit_verification" class="btn btn-primary">Submit for Verification</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Poll Sections (Visible to All Users) -->
        <div class="section">
            <h3>Available Polls</h3>
            <p>Vote on existing polls.</p>
            <!-- Add your polls list here -->
        </div>

        <!-- Create Poll Sections (Visible Only to Verified Users) -->
        <?php if ($verified): ?>
            <div class="section">
                <h3>Create New Polls</h3>
                <p>As a verified user, you can create new polls in different categories.</p>

                <div class="mb-3">
                    <button class="btn btn-primary btn-create-poll" onclick="createPoll('sports')">Create Sports Poll</button>
                    <button class="btn btn-primary btn-create-poll" onclick="createPoll('politics')">Create Politics Poll</button>
                    <button class="btn btn-primary btn-create-poll" onclick="createPoll('mcq')">Create MCQ Poll</button>
                    <button class="btn btn-primary btn-create-poll" onclick="createPoll('custom')">Create Custom Poll</button>
                </div>
            </div>
        <?php endif; ?>

        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script>
        function createPoll(type) {
            alert(`Redirecting to create ${type} poll page...`);
        }
    </script>
</body>
</html>
