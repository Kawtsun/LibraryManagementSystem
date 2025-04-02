<?php

include '../validate/db.php';
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the connection was successful
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

try {
    // Set character encoding
    $conn->set_charset("utf8");

    // Retrieve data from database
    $sql_users = "SELECT * FROM users";
    $result_users = $conn->query($sql_users);
    $users = $result_users ? $result_users->fetch_all(MYSQLI_ASSOC) : [];


    // Fetch all books using the combined query from admin_books.php
    $sql_books = "
        (
        SELECT id, title, author, subject, publication_year, date_added, quantity, Available,
                'B-B-' AS prefix, 1 AS src_order, 'books' AS source
        FROM books
        )
        UNION ALL
        (
        SELECT id, title, author, subject, publication_year, date_added, quantity, Available,
                'B-A-' AS prefix, 3 AS src_order, 'author_books' AS source
        FROM author_books
        )
        UNION ALL
        (
        SELECT id, title, NULL AS author, topic AS subject, NULL AS publication_year, date_added, quantity, Available,
                'B-L-' AS prefix, 2 AS src_order, 'library_books' AS source
        FROM library_books
        )
        ORDER BY src_order ASC, id ASC
    ";

    $result_books = $conn->query($sql_books);
    $books = $result_books ? $result_books->fetch_all(MYSQLI_ASSOC) : [];

    $sql_transactions = "SELECT * FROM transactions";
    $result_transactions = $conn->query($sql_transactions);
    $transactions = $result_transactions ? $result_transactions->fetch_all(MYSQLI_ASSOC) : [];

    $spreadsheet = new Spreadsheet();

    // Users sheet
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Registered Users');
    if (!empty($users)) {
        $sheet->fromArray(array_keys($users[0]), null, 'A1');
        $sheet->fromArray($users, null, 'A2');
    }

    // Books sheet
    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('All Books'); // Changed title to reflect the data
    if (!empty($books)) {
        $headers = ['ID', 'Title', 'Author', 'Subject', 'Publication Year', 'Date Added', 'Quantity', 'Available', 'Prefix', 'Source Order', 'Source'];
        $sheet2->fromArray($headers, null, 'A1');
        $sheet2->fromArray($books, null, 'A2');
    }

    // Transactions sheet
    $sheet3 = $spreadsheet->createSheet();
    $sheet3->setTitle('Transactions');
    if (!empty($transactions)) {
        $sheet3->fromArray(array_keys($transactions[0]), null, 'A1');
        $sheet3->fromArray($transactions, null, 'A2');
    }

    // Save and download
    $writer = new Xlsx($spreadsheet);
    $filename = 'all_reports.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');

} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
} finally {
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>
