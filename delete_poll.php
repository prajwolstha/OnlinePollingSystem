<?php
include 'connection.php';
// Fetch poll ID
$poll_id = $_GET['id'];

// Delete poll
$sql = "DELETE FROM polls WHERE id='$poll_id'";
$conn->query($sql);

// Redirect back to poll management
header('Location: poll_management.php');
exit();
?>
