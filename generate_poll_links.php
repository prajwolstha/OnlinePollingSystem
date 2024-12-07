<?php
include 'connection.php';

// Ensure this script is only accessible to admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. Only admins can perform this action.");
}

$sql = "SELECT id FROM polls";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $unique_link = uniqid("poll_", true);
        $updateSql = "UPDATE polls SET unique_link='$unique_link' WHERE id=" . $row['id'];
        if (!$conn->query($updateSql)) {
            echo "Error updating poll ID " . $row['id'] . ": " . $conn->error . "<br>";
        }
    }
    echo "Unique links generated for all polls!";
} else {
    echo "Error fetching polls: " . $conn->error;
}
?>
