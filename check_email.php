<?php
$conn = new mysqli('localhost', 'root', '', 'dstudios_poll');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    $checkEmailSql = "SELECT * FROM prayojan WHERE email = ?";
    $stmt = $conn->prepare($checkEmailSql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
}
