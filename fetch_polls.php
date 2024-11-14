<?php
include 'connection.php';

$user_id = $_GET['user_id'];
$sql = "SELECT id, question FROM polls WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$polls = [];
while ($row = $result->fetch_assoc()) {
    $polls[] = $row;
}
echo json_encode($polls);
?>
