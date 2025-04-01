<?php
// Include your database connection file.
include '../validate/db.php';

// Get the search query from the request.
$query = isset($_GET['q']) ? trim($_GET['q']) : "";

$response = []; // Array to store matching transactions.

if ($query !== "") {
    // Escape the query to prevent SQL injection.
    $queryEscaped = $conn->real_escape_string($query);

    // Query to fetch transactions where `completed = 0` and match the query.
    $sql = "
        SELECT transaction_id, name, book_id, email
        FROM transactions
        WHERE completed = 0
        AND (name LIKE '%$queryEscaped%' 
        OR email LIKE '%$queryEscaped%' 
        OR book_id LIKE '%$queryEscaped%')
        ORDER BY transaction_id ASC
        LIMIT 10
    ";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = [
                'transaction_id' => $row['transaction_id'],
                'name' => $row['name'],
                'book_id' => $row['book_id'],
                'email' => $row['email']
            ];
        }
    }
}

// Output the response in JSON format.
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
