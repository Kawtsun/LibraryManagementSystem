<?php
include '../validate/db.php'; // Include database connection

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];

    // Validate user ID
    if ($user_id <= 0) {
        die("Invalid user ID.");
    }

    // Delete user from the database
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Redirect to admin-users.php with success status
            header("Location: admin-users.php?status=deleted");
            exit;
        } else {
            echo "No user found with the specified ID.";
        }
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid user ID.";
}

// Close the database connection
$conn->close();
?>
