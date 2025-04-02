<?php
include '../validate/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['barcode'])) {
    $barcode = $conn->real_escape_string($_POST['barcode']);

    error_log("Received barcode: " . $barcode); // Log received barcode

    $sql_update_transaction = "UPDATE transactions t
                                SET t.completed = 1, t.date_returned = NOW()
                                WHERE LOWER(t.barcode) = LOWER('$barcode') 
                                AND t.completed = 0";

    error_log("Executing SQL: " . $sql_update_transaction); // Log SQL query

    if ($conn->query($sql_update_transaction) === TRUE) {
        $affected_rows = $conn->affected_rows;
        error_log("Affected rows: " . $affected_rows); // Log affected rows

        if ($affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Book returned successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No active transaction found for barcode: ' . $barcode]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error returning book: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>