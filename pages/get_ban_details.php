<?php
include '../validate/db.php';

header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $sql = "SELECT ban_expiry_date, ban_reason FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['expiry_date' => $row['ban_expiry_date'], 'ban_reason' => $row['ban_reason']]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Username not provided']);
}

$conn->close();
?>