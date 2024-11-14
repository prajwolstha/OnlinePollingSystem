<?php
include 'connection.php';

$poll_id = $_GET['poll_id'];
$sql = "SELECT option_text, COUNT(votes.option_id) as votes FROM poll_options 
        LEFT JOIN votes ON poll_options.id = votes.option_id 
        WHERE poll_options.poll_id = '$poll_id' 
        GROUP BY poll_options.id";
$result = $conn->query($sql);

$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = $row;
}
echo json_encode($options);
?>
