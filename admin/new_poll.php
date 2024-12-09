<?php
include '../includes/sidebar.php';
include '../includes/header.php';
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $poll_title = $conn->real_escape_string($_POST['poll_title']);
    $options = $_POST['options'];
    $end_date = $_POST['end_date'];

    // Insert poll
    $conn->query("INSERT INTO polls (question, end_date) VALUES ('$poll_title', '$end_date')");
    $poll_id = $conn->insert_id;

    // Insert options
    foreach ($options as $option) {
        $conn->query("INSERT INTO poll_options (poll_id, option_text) VALUES ('$poll_id', '{$conn->real_escape_string($option)}')");
    }

    echo "<script>alert('New poll created successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Poll</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="content">
        <h1>Create New Poll</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="poll_title" class="form-label">Poll Title</label>
                <input type="text" id="poll_title" name="poll_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Options</label>
                <div id="options-container">
                    <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 1" required>
                    <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 2" required>
                </div>
                <button type="button" id="add-option" class="btn btn-secondary">Add Option</button>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Poll</button>
        </form>
    </div>
    <script>
        document.getElementById('add-option').addEventListener('click', function() {
            const container = document.getElementById('options-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Option ' + (container.children.length + 1);
            container.appendChild(input);
        });
    </script>
    <style>
        /* Sidebar styling */
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    background-color: #f8f9fa;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

/* Content area adjustments */
.content {
    margin-left: 260px; /* Ensures content starts after the sidebar */
    padding: 20px;
}

    </style>
</body>
</html>
