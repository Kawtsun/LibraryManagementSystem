<?php
// searchUsers.php

// Include or require your database configuration file
require_once '../validate/db.php';

if (isset($_GET['q'])) {
    $q = $conn->real_escape_string($_GET['q']);
    // Query the database for users matching the search input (limit results to 10)
    $sql = "SELECT user_id, username FROM users WHERE username LIKE '%$q%' LIMIT 10";
    $result = $conn->query($sql);

    $users = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    header("Content-Type: application/json");
    echo json_encode($users);
    exit;
}
?>
