<?php
// Include your database connection.
include '../validate/db.php';

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// *** CRITICAL: Adjust these paths to match your setup! ***
require '../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/PHPMailer-master/src/SMTP.php';

include_once 'email_functions.php'; // Include the file containing send_email()

if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Get the search query (if any) for transactions.
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";

// Define pagination variables.
$records_per_page = 10; // Number of records per page.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number.
$page = max($page, 1); // Ensure page is not less than 1.
$offset = ($page - 1) * $records_per_page; // Calculate offset for SQL query.

// Build the search condition for incomplete transactions.
$searchCondition = "WHERE t.completed = 0"; // Default condition for incomplete transactions.
if ($searchQuery !== "") {
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $searchCondition = "
        WHERE (t.name LIKE '%$searchQueryEscaped%' 
        OR t.email LIKE '%$searchQueryEscaped%'
        OR t.book_title LIKE '%$searchQueryEscaped%')
        AND t.completed = 0
    ";
}

// Main UNION query: Fetch incomplete transactions and their source tables.
$sql_transactions = "
    SELECT t.transaction_id, t.email, t.name, t.book_title, t.date_borrowed, t.return_date, t.date_returned,
        CASE
            WHEN b.title IS NOT NULL THEN 'books'
            WHEN ab.title IS NOT NULL THEN 'author_books'
            WHEN lb.title IS NOT NULL THEN 'library_books'
            ELSE NULL
        END AS source
    FROM transactions t
    LEFT JOIN books b ON t.book_title = b.title
    LEFT JOIN author_books ab ON t.book_title = ab.title
    LEFT JOIN library_books lb ON t.book_title = lb.title
    $searchCondition
    ORDER BY t.transaction_id ASC
    LIMIT $records_per_page OFFSET $offset
";

$result_transactions = $conn->query($sql_transactions);
$transactions = [];
if ($result_transactions && $result_transactions->num_rows > 0) {
    while ($row = $result_transactions->fetch_assoc()) {
        $transactions[] = $row;

        // *** Late Return Email Logic (Calculated in PHP) ***
        $returnDate = strtotime($row['return_date']);
        $dateReturned = strtotime($row['date_returned']);

        // Check if the book has been returned and if it was returned late.
        // Also check if date_returned is not NULL (to avoid errors if not returned yet)
        if ($row['date_returned'] !== null && $dateReturned !== false && $dateReturned > $returnDate) {
            $email_address = $row['email'];
            $name = $row['name'];
            $book_title = $row['book_title'];

            if (!send_email(email_address: $email_address, name: $name, book_title: $book_title)) {
                error_log("Failed to send late return email to: " . $email_address);
            }
        }
        // *** End Late Return Email Logic ***
    }
}

// Count total incomplete transactions matching the search for pagination.
$sql_count = "
    SELECT COUNT(*) AS total
    FROM transactions t
    LEFT JOIN books b ON t.book_title = b.title
    LEFT JOIN author_books ab ON t.book_title = ab.title
    LEFT JOIN library_books lb ON t.book_title = lb.title
    $searchCondition
";
$result_count = $conn->query($sql_count);
$total_transactions = ($result_count) ? $result_count->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_transactions / $records_per_page);

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Registered Users</title>
    <style>
    /* General styling */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        font-size: 13px; /* Bahagyang laki */
    }

    /* Header - Full Width and Fixed at the Top */
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1001;
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px; /* Bahagyang laki */
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); /* Bahagyang laki */
        height: 55px; /* Bahagyang laki */
    }

    header .logo-container {
        display: flex;
        align-items: center;
    }

    header .logo-container img {
        width: 70px; /* Bahagyang laki */
        margin-right: 10px; /* Bahagyang laki */
    }

    header .logo-container span {
        font-size: 20px; /* Bahagyang laki */
        font-weight: bold;
    }

    .sidebar img {
        border-radius: 50%;
        width: 70px; /* Bahagyang laki */
        display: block;
        margin: 25px auto 10px; /* Bahagyang laki */
    }

    .sidebar h3 {
        text-align: center;
        margin: 12px 0; /* Bahagyang laki */
        font-size: 17px; /* Bahagyang laki */
    }

    .sidebar ul a .lucide {
        width: 18px; /* Bahagyang laki */
        height: 18px; /* Bahagyang laki */
        margin-right: 9px; /* Bahagyang laki */
        vertical-align: middle;
    }

    .logout .lucide {
        width: 18px; /* Bahagyang laki */
        height: 18px; /* Bahagyang laki */
        margin-right: 9px; /* Bahagyang laki */
        vertical-align: middle;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 55px; /* Adjusted top */
        left: 0;
        height: calc(100vh - 55px); /* Adjusted height */
        width: 220px; /* Bahagyang laki */
        background-color: #007BFF;
        color: white;
        padding: 18px; /* Bahagyang laki */
        box-sizing: border-box;
        overflow-y: auto;
        z-index: 1000;
    }

    /* Main Navigation Links */
    .sidebar ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    /* General Navigation Links */
    .sidebar ul a {
        display: block;
        margin: 9px 0; /* Bahagyang laki */
        padding: 14px; /* Bahagyang laki */
        background-color: #0056b3;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 14px; /* Bahagyang laki */
        font-weight: bold;
        transition: background-color 0.3s, padding-left 0.3s;
    }

    .sidebar ul a:hover {
        background-color: #004080;
    }

    .sidebar ul a.active {
        background-color: #004080;
        font-weight: bold;
        color: white;
        border-left: 4px solid #3498db;
        padding-left: 14px; /* Bahagyang laki */
    }

    /* Logout Button - Positioned at the Bottom */
    .logout {
        list-style: none;
        position: absolute;
        bottom: 35px; /* Bahagyang laki */
        left: 16px; /* Bahagyang laki */
        right: 18px; /* Bahagyang laki */
        display: block;
        padding: 14px; /* Bahagyang laki */
        background-color: #0056b3;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 15px; /* Bahagyang laki */
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .logout:hover {
        background-color: #004080;
    }

    .logout i {
        width: 18px; /* Bahagyang laki */
        height: 18px; /* Bahagyang laki */
        margin-right: 9px; /* Bahagyang laki */
        vertical-align: middle;
    }

    /* Main Content */
    .main-content {
        margin-left: 220px; /* Adjusted margin */
        padding: 18px; /* Bahagyang laki */
        margin-top: 55px; /* Adjusted margin */
        box-sizing: border-box;
        min-height: calc(100vh - 55px); /* Adjusted height */
    }

    /* Container for search bar and Add User button */
    .search-bar-container {
        display: flex;
        flex-wrap: wrap; /* Allow wrapping of buttons */
        justify-content: space-between;
        align-items: flex-start;
        gap: 9px; /* Bahagyang laki */
    }

    .search-bar-container button {
        padding: 9px 18px; /* Bahagyang laki */
        font-size: 15px; /* Bahagyang laki */
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-bar-container button:hover {
        background-color: rgb(46, 132, 190);
        transform: scale(1.04); /* Bahagyang laki */
    }

    /* Wrapper for input and suggestions for relative positioning */
    .search-input-wrapper {
        position: relative;
        width: 270px; /* Bahagyang laki */
    }

    .search-input-wrapper input {
        padding: 9px 65px 9px 9px; /* Bahagyang laki */
        font-size: 15px; /* Bahagyang laki */
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Clear Button Styled as a Box */
    .clear-search {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        padding: 0 11px; /* Bahagyang laki */
        background: #e74c3c;
        color: #fff;
        border: none;
        font-size: 15px; /* Bahagyang laki */
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .clear-search:hover {
        background: #c0392b;
    }

    .clear-search:active {
        background: #a93226;
    }

    /* Suggestions dropdown styling */
    .suggestions-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ccc;
        border-top: none;
        border-radius: 0 0 4px 4px;
        list-style: none;
        margin: 0;
        padding: 0;
        z-index: 1000;
        max-height: 170px; /* Bahagyang laki */
        overflow-y: auto;
    }

    .suggestions-list li {
        padding: 9px; /* Bahagyang laki */
        cursor: pointer;
        font-size: 15px; /* Bahagyang laki */
    }

    .suggestions-list li:hover {
        background-color: #f5f5f5;
    }

    .transactions-table {
        width: 100%;
        background-color: white;
        border-collapse: collapse;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); /* Bahagyang laki */
        border-radius: 6px;
        overflow: hidden;
        margin-top: 18px; /* Bahagyang laki */
        font-size: 13px; /* Bahagyang laki */
    }

    .transactions-table th,
    .transactions-table td {
        padding: 12px; /* Bahagyang laki */
        text-align: left;
        border-bottom: 1px solid #f4f4f4;
        word-wrap: break-word;
        white-space: normal;
    }

    .transactions-table th {
        background-color: #007BFF;
        color: white;
        text-transform: uppercase;
        font-size: 15px; /* Bahagyang laki */
    }

    .transactions-table tr:hover {
        background-color: #f9f9f9;
    }

    .transactions-table td .action-buttons {
        display: flex; /* Arrange buttons in a row */
        justify-content: center; /* Center the buttons horizontally */
        align-items: center; /* Center the buttons vertically */
        gap: 6px; /* Bahagyang laki */
    }

    .transactions-table td button,
    .transactions-table td form button {
        padding: 9px 14px; /* Bahagyang laki */
        font-size: 13px; /* Bahagyang laki */
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .transactions-table td button:hover,
    .transactions-table td form button:hover {
        background-color: rgb(46, 132, 190);
        transform: scale(1.04); /* Bahagyang laki */
    }

    .transactions-table td .return-btn {
        background-color: #2ecc71;
    }

    .transactions-table td .return-btn:hover {
        background-color: #28a860;
    }

    .transactions-table td .delete-btn {
        background-color: #e74c3c;
    }

    .transactions-table td .delete-btn:hover {
        background-color: #c0392b;
    }

    /* New Pagination styling as provided */
    .pagination {
        margin-top: 25px; /* Bahagyang laki */
        text-align: center;
    }

    .pagination a {
        text-decoration: none;
        color: #007BFF;
        padding: 5px 10px; /* Bahagyang laki */
        border: 1px solid #ddd;
        border-radius: 3px;
        margin: 0 4px; /* Bahagyang laki */
        transition: background-color 0.3s;
        font-size: 13px; /* Bahagyang laki */
    }

    .pagination a:hover {
        background-color: #f4f4f4;
    }

    .pagination a.disabled {
        color: #aaa;
        cursor: not-allowed;
    }

    /* General Button Styling */
    button {
        padding: 9px 18px; /* Bahagyang laki */
        font-size: 13px; /* Bahagyang laki */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    /* Add User Button */
    #addUserBtn {
        background-color: #3498db;
        color: white;
        font-weight: bold;
    }

    #addUserBtn:hover {
        background-color: #217dbb;
        transform: scale(1.04); /* Bahagyang laki */
    }

    /* Print Button */
    .view-button {
        background-color: #3498db;
        color: white;
    }

    .view-button:hover {
        background-color: #2e84be;
        transform: scale(1.04); /* Bahagyang laki */
    }

    /* Return Button */
    .return-btn {
        background-color: #2ecc71;
        color: white;
    }

    .return-btn:hover {
        background-color: #28a860;
        transform: scale(1.04); /* Bahagyang laki */
    }

    /* Delete Button */
    .delete-btn {
        background-color: #e74c3c;
        color: white;
    }

    .delete-btn:hover {
        background-color: #c0392b;
        transform: scale(1.04); /* Bahagyang laki */
    }

    .modal-content .delete-button {
        background-color: #e74c3c;
        color: white;
    }

    .modal-content .delete-button:hover {
        background-color: #c0392b;
        transform: scale(1.04); /* Bahagyang laki */
    }

    /* Modal Background Overlay */
    .modal {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Semi-transparent background */
        z-index: 1002;
        justify-content: center;
        align-items: center;
    }

    /* Modal Content Box */
    .modal-content {
        background-color: white;
        border-radius: 6px;
        padding: 18px; /* Bahagyang laki */
        width: 90%;
        max-width: 1200px;
        max-height: 80%;
        /* Restrict height to fit viewport */
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1); /* Bahagyang laki */
        overflow: auto;
        /* Makes content scrollable if it exceeds modal height */
        position: relative;
        text-align: left;
    }

    /* Modal Close Button Styling */
    .close {
        position: absolute;
        top: 14px; /* Bahagyang laki */
        right: 14px; /* Bahagyang laki */
        color: #888;
        font-size: 19px; /* Bahagyang laki */
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #444;
        /* Darker shade for hover state */
    }

    /* Modal Table Styling */
    .modal-content .transactions-table {
        width: 100%;
        background-color: white;
        border-collapse: collapse;
        box-shadow: none;
        /* Shadow removed to keep it clean inside modal */
        border-radius: 0;
        margin: 0;
        font-size: 13px; /* Bahagyang laki */
    }

    .modal-content .transactions-table th,
    .modal-content .transactions-table td {padding: 12px; /* Bahagyang laki */
        text-align: left;
        border-bottom: 1px solid #f4f4f4;
    }

    .modal-content .transactions-table th {
        background-color: #007BFF;
        /* Matches table header styling */
        color: white;
        text-transform: uppercase;
        font-size: 12px; /* Bahagyang laki */
    }

    .modal-content .transactions-table tr:hover {
        background-color: #f9f9f9;
    }

    /* Form Fields and Buttons Inside Modals */
    .modal-content label {
        display: block;
        font-weight: bold;
        margin: 11px 0 6px 0; /* Bahagyang laki */
        color: #333;
        /* Darker text for readability */
        font-size: 15px; /* Bahagyang laki */
    }

    .modal-content input,
    select {
        width: 100%;
        /* Full width matching the modal */
        padding: 9px; /* Bahagyang laki */
        margin-top: 5px; /* Bahagyang laki */
        border: 1px solid #ccc;
        /* Softer border color */
        border-radius: 4px;
        box-sizing: border-box;
        /* Ensures proper width calculation */
        font-size: 15px; /* Bahagyang laki */
    }

    .modal-content input:focus,
    select:focus {
        outline: none;
        border: 1px solid #3498db;
        /* Blue border for focus state */
        box-shadow: 0px 0px 4px rgba(52, 152, 219, 0.5);
        /* Glow effect on focus */
    }

    .modal-content button {
        margin-top: 18px; /* Bahagyang laki */
        padding: 11px 22px; /* Bahagyang laki */
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        /* Slightly rounded button corners */
        cursor: pointer;
        width: 100%;
        /* Full width button */
        font-size: 15px; /* Bahagyang laki */
        font-weight: bold;
        /* Prominent button text */
        transition: background-color 0.3s ease;
        /* Smooth hover transition */
    }

    .modal-content button:hover {
        background-color: #217dbb;
        /* Slightly darker blue for hover state */
    }

    /* Error Box Styling */
    .error-box {
        background-color: #ffefef;
        /* Light pink for error background */
        color: #b71c1c;
        /* Bold dark red for text */
        padding: 14px; /* Bahagyang laki */
        /* Extra padding for breathing space */
        border: 1px solid #f5c6cb;
        /* Softer pink border */
        border-radius: 8px;
        /* More rounded corners for a softer look */
        margin-bottom: 18px; /* Bahagyang laki */
        display: none;
        /* Hidden by default */
        font-size: 15px;
        /* Slightly larger font for readability */
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        /* Shadow for depth */
        animation: fadeIn 0.5s ease-in-out;
        /* Smooth appearance animation */
    }

    /* Error List Styling */
    .error-box ul {
        list-style: none;
        /* Remove bullets */
        padding: 0;
        margin: 0;
    }

    .error-box li {
        margin-bottom: 9px; /* Bahagyang laki */
        /* Space between individual errors */
        font-weight: bold;
        /* Highlight each error */
        line-height: 1.5; /* Bahagyang laki */
        /* Improve readability with better spacing */
        font-size: 14px; /* Bahagyang laki */
    }

    /* Fade-in Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-6px); /* Bahagyang laki */
            /* Slight slide effect */
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #button-container {
        display: flex;
        align-items: center;
        /* Optional: Align buttons vertically */
    }

    #barcode-scanner-container {
    display: flex;
    flex-wrap: wrap; /* Allow wrapping of scanner buttons */
    gap: 9px; /* Bahagyang laki */
    align-items: center;
    justify-content: center; /* Center buttons horizontally */
    /* Align buttons vertically */
}

#startScanBtn,
#stopScanBtn {
    padding: 9px 18px; /* Bahagyang laki */
    font-size: 15px; /* Bahagyang laki */
    background-color: #3498db; /* Same background color */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer; /* Match font size of the completed button */
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-left: 675px; 
}

#startScanBtn:hover,
#stopScanBtn:hover {
    background-color: rgb(46, 132, 190); /* Same hover color as the completed button */
    transform: scale(1.04); /* Bahagyang laki */
}

#scanner {
    margin-top: 9px; /* Bahagyang laki */
    display: flex;
    justify-content: center; /* Center the video horizontally */
}

    .transactions-table td {
        white-space: normal;
        /* Allow wrapping of table cell content */
        text-align: center;
        /* Center align content for better layout */
    }

    .transactions-table td .action-buttons {
        display: flex; /* Arrange buttons in a row */
        justify-content: center; /* Center the buttons horizontally */
        align-items: center; /* Center the buttons vertically */
        gap: 7px; /* Bahagyang laki */
    }

    .transactions-table td button,
    .transactions-table td form button {
        padding: 10px 16px; /* Bahagyang laki */
        font-size: 14px; /* Bahagyang laki */
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .transactions-table td button:hover,
    .transactions-table td form button:hover {
        background-color: rgb(46, 132, 190);
        transform: scale(1.04); /* Bahagyang laki */
    }

    .transactions-table td .action-buttons button.return-btn {
        background-color: #2ecc71;
    }

    .transactions-table td .action-buttons button.return-btn:hover {
        background-color: #28a860;
    }

    .transactions-table td .action-buttons button.delete-btn {
        background-color: #e74c3c;
    }

    .transactions-table td .action-buttons button.delete-btn:hover {
        background-color: #c0392b;
    }

    #completedTransactionsModal .action-buttons {
        display: block; /* Revert to block layout for modal buttons */
    }

    #completedTransactionsModal .action-buttons button,
    #completedTransactionsModal .action-buttons form button {
        padding: 11px 22px; /* Bahagyang laki */
        font-size: 15px; /* Bahagyang laki */
    }

    .transactions-table td .action-buttons button.return-btn {
        background-color: #2ecc71;
    }

    .transactions-table td .action-buttons button.return-btn:hover {
        background-color: #28a860;
    }

    .transactions-table td .action-buttons button.delete-btn {
        background-color: #e74c3c;
    }

    .transactions-table td .action-buttons button.delete-btn:hover {
        background-color: #c0392b;
    }
</style>


    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
</head>

<body>
    <div id="status-handler" data-status="<?php echo isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''; ?>"></div>

    <!-- Header -->
    <header>
        <div class="logo-container">
            <img src="../img/LMS_logo.png" alt="Library Logo">
            <span>AklatURSM Management System</span>
        </div>
    </header>

    <!-- Dashboard Container -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <img src="admin.jpg" alt="Admin Avatar">
            <h3>Admin</h3>
            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            ?>
            <ul>
                <a href="admin-dashboard.php" class="<?php echo $currentPage === 'admin-dashboard.php' ? 'active' : ''; ?>">
                    <li>
                        <i class="lucide" data-lucide="home"></i> Dashboard
                    </li>
                </a>
                <a href="admin-users.php" class="<?php echo $currentPage === 'admin-users.php' ? 'active' : ''; ?>">
                    <li>
                        <i class="lucide" data-lucide="users"></i> Registered Users
                    </li>
                </a>
                <a href="admin-books.php" class="<?php echo $currentPage === 'admin-books.php' ? 'active' : ''; ?>">
                    <li>
                        <i class="lucide" data-lucide="book"></i> Registered Books
                    </li>
                </a>
                <a href="admin-transactions.php" class="<?php echo $currentPage === 'admin-transactions.php' ? 'active' : ''; ?>">
                    <li>
                        <i class="lucide" data-lucide="file-text"></i> Transactions
                    </li>
                </a>
            </ul>
            <a href="logoutAdmin.php" class="logout">
                <li>
                    <i class="lucide" data-lucide="log-out"></i> Logout
                </li>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Transactions</h2>
            <h3>Incomplete Transaction</h3>
            <div class="search-bar-container">
                <div class="search-input-wrapper">
                    <input type="text" id="searchInput" placeholder="Search Transactions..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <?php if (!empty($searchQuery)): ?>
                        <a href="admin-transactions.php" class="clear-search">Clear</a>
                    <?php endif; ?>
                    <ul id="suggestions" class="suggestions-list"></ul>
                </div>
                <div id="barcode-scanner-container" style="background-color: transparent;">
                    <button id="startScanBtn" onclick="startScan()">Start Scan</button>
                    <button id="stopScanBtn" onclick="stopScan()" style="display: none;">Stop Scan</button>
                    <video id="scanner" width="640" height="480" style="display: none;"></video>
                    <p id="scanResult"></p>
                </div>
                <button id="openCompletedTransactions" class="open-completed-button">
                    Completed Transactions
                </button>
            </div>

            <!-- Completed Transactions Modal -->
            <div id="completedTransactionsModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('completedTransactionsModal').style.display='none'">&times;</span>
                    <h2>Completed Transactions</h2>
                    <div id="completedTransactionsErrorMessages" class="error-box"></div> <!-- Error messages -->
                    <table class="transactions-table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Book Title</th>
                                <th>Date Borrowed</th>
                                <th>Return Date</th>
                                <th>Date Returned</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="completedTransactionsBody">
                            <!-- Dynamic rows will be injected here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="transactions-table-container">
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Book Title</th>
                            <th>Date Borrowed</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">No incomplete transactions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <?php
                                // Calculate Status
                                $returnDateTimestamp = strtotime($transaction['return_date']);
                                // Check if strtotime was successful
                                if ($returnDateTimestamp === false) {
                                    $status = 'Invalid Date'; // Handle invalid date
                                    error_log("Invalid return_date: " . $transaction['return_date'] . " for transaction ID: " . $transaction['transaction_id']);
                                } else {
                                    $nowTimestamp = time();
                                    $status = ($nowTimestamp > $returnDateTimestamp) ? 'Late Return' : 'Active'; // Ternary operator for brevity
                                }
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['email']); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['name']); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['book_title']); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['date_borrowed']); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['return_date']); ?></td>
                                    <td class="status <?php echo ($status == 'Late Return') ? 'late' : (($status == 'Invalid Date') ? 'invalid' : 'active'); ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </td>
                                    <td class="action-buttons">
                                        <form action="../pages/print_transaction.php" method="get" target="_blank" style="display:inline;">
                                            <input type="hidden" name="transaction_id" value="<?php echo $transaction['transaction_id']; ?>">
                                            <button type="submit" class="view-button">Print PDF</button>
                                        </form>
                                        <button
                                            class="return-btn"
                                            onclick="markAsReturned(<?php echo $transaction['transaction_id']; ?>)">
                                            Return
                                        </button>
                                        <button class="delete-btn" onclick="confirmDeleteTransaction(<?php echo $transaction['transaction_id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                                <?php
                                // ... rest of your code ...

                                if ($status == 'Late Return') {
                                    $email_address = $transaction['email'];
                                    $name = $transaction['name'];
                                    $book_title = $transaction['book_title'];

                                    if (!send_email(email_address: $email_address, name: $name, book_title: $book_title)) {
                                        error_log("Failed to send late return email to: " . $email_address);
                                        // Optionally, you could add a message to the admin interface
                                        // to indicate that the email failed to send.
                                    }
                                }
                                ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <style>
                .late {
                    color: red;
                }

                .active {
                    color: green;
                }
            </style>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo (isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''); ?>">← Previous</a>
                <?php else: ?>
                    <a class="disabled">← Previous</a>
                <?php endif; ?>

                <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo (isset($_GET['search']) && $_GET['search'] !== '' ? '&search=' . urlencode($_GET['search']) : ''); ?>">Next →</a>
                <?php else: ?>
                    <a class="disabled">Next →</a>
                <?php endif; ?>
            </div>

            <script>
                window.confirmDeleteTransaction = function(transactionId) {
                    const currentPage = 1; // Default page if undefined
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Deleting this transaction cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#3498db',
                        confirmButtonText: 'Yes, delete it!',
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = `delete-transaction.php?id=${transactionId}&page=${currentPage}&completed=true&status=success`;
                        }
                    });
                };
            </script>

            <script>
                lucide.createIcons();
            </script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchInput = document.getElementById("searchInput");
                    const suggestionsList = document.getElementById("suggestions");

                    if (searchInput) {
                        searchInput.addEventListener("input", function() {
                            const query = this.value.trim();
                            if (query.length > 0) {
                                fetch(`searchTransactions.php?q=${encodeURIComponent(query)}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        suggestionsList.innerHTML = "";
                                        if (data.length > 0) {
                                            data.forEach(transaction => {
                                                const li = document.createElement("li");
                                                li.textContent = `${transaction.name} - ${transaction.book_title}`;
                                                li.addEventListener("click", function() {
                                                    searchInput.value = `${transaction.name}`;
                                                    window.location.href = `admin-transactions.php?search=${encodeURIComponent(transaction.name)}`;
                                                });
                                                suggestionsList.appendChild(li);
                                            });
                                        } else {
                                            const li = document.createElement("li");
                                            li.textContent = "No incomplete transactions found";
                                            suggestionsList.appendChild(li);
                                        }
                                    })
                                    .catch(error => console.error("Error fetching search results:", error));
                            } else {
                                suggestionsList.innerHTML = "";
                            }
                        });

                        searchInput.addEventListener("keydown", function(e) {
                            if (e.key === "Enter") {
                                e.preventDefault();
                                window.location.href = `admin-transactions.php?search=${encodeURIComponent(this.value.trim())}`;
                            }
                        });
                    }
                });
            </script>

            <script>
                // Open Completed Transactions Modal and Load Data
                document.addEventListener("DOMContentLoaded", function() {
                    const completedTransactionsModal = document.getElementById('completedTransactionsModal');
                    const completedTransactionsBody = document.getElementById('completedTransactionsBody');

                    // Function to open the modal
                    window.openCompletedTransactionsModal = function() {
                        if (!completedTransactionsModal) {
                            console.error("Completed Transactions modal element not found");
                            return;
                        }

                        // Show the modal
                        completedTransactionsModal.style.display = "flex";

                        // Dynamically load completed transactions
                        loadCompletedTransactions();
                    };

                    // Function to fetch and load completed transaction data
                    function loadCompletedTransactions() {
                        fetch('fetch-completed-transactions.php') // Replace with your backend file path
                            .then(response => response.json())
                            .then(data => {
                                completedTransactionsBody.innerHTML = ''; // Clear previous content

                                if (data.length > 0) {
                                    data.forEach(transaction => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                                <td>${transaction.transaction_id}</td>
                                <td>${transaction.email}</td>
                                <td>${transaction.name}</td>
                                <td>${transaction.book_title}</td>
                                <td>${transaction.date_borrowed}</td>
                                <td>${transaction.return_date}</td>
                                <td>${transaction.date_returned}</td>
                                <td class="action-buttons">
                                    <form action="../pages/print_transaction.php" method="get" target="_blank" style="display:inline;">
                                        <input type="hidden" name="transaction_id" value="${transaction.transaction_id}">
                                        <button type="submit" class="view-button">Print PDF</button>
                                    </form>
                                    <button onclick="confirmDeleteTransactionCompleted(${transaction.transaction_id})" class="delete-button">Delete</button>
                                </td>
                            `;
                                        completedTransactionsBody.appendChild(row);
                                    });
                                } else {
                                    completedTransactionsBody.innerHTML = '<tr><td colspan="8" style="text-align:center;">No completed transactions found.</td></tr>';
                                }
                            })
                            .catch(error => console.error('Error loading completed transactions:', error));
                    }

                    // Delete function for completed transactions
                    window.confirmDeleteTransactionCompleted = function(transactionId) {
                        const currentPage = 1; // Default page if undefined
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Deleting this transaction cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e74c3c',
                            cancelButtonColor: '#3498db',
                            confirmButtonText: 'Yes, delete it!',
                        }).then(result => {
                            if (result.isConfirmed) {
                                window.location.href = `delete-transaction.php?id=${transactionId}&page=${currentPage}&completed=true&status=success`;
                            }
                        });
                    };

                    // Bind click event to the button for opening the modal
                    const openButton = document.getElementById('openCompletedTransactions');
                    if (openButton) {
                        openButton.addEventListener("click", function() {
                            openCompletedTransactionsModal();
                        });
                    }

                    // Close modal when clicking on any element with the `.close` class
                    document.querySelectorAll('#completedTransactionsModal .close').forEach(function(closeBtn) {
                        closeBtn.addEventListener("click", function() {
                            completedTransactionsModal.style.display = "none";
                        });
                    });

                    // Close the modal if clicking outside its content
                    window.addEventListener("click", function(event) {
                        if (event.target === completedTransactionsModal) {
                            completedTransactionsModal.style.display = "none";
                        }
                    });
                });
            </script>

            <script>
                // Deleting transactions
                function confirmDeleteTransaction(transactionId) {
                    // Retrieve current page for maintaining pagination context
                    const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#3498db',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the delete-transaction.php script, passing the transaction ID and current page
                            window.location.href = `delete-transaction.php?id=${transactionId}&page=${currentPage}&status=success`;
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', () => {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('status') === 'success') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The transaction has been successfully deleted.',
                            icon: 'success',
                            confirmButtonColor: '#3498db',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optional: Remove the status parameter from the URL to prevent duplicate alerts
                            urlParams.delete('status');
                            window.history.replaceState({}, document.title, `${location.pathname}?${urlParams}`);
                        });
                    }
                });
            </script>

            <script>
                function markAsReturned(transactionId, source) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to mark this transaction as returned.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, mark as returned!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const currentTime = new Date().toISOString(); // Get current time in ISO format
                            fetch('mark-as-returned.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `transaction_id=${transactionId}&source=${source}&date_returned=${encodeURIComponent(currentTime)}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Success', data.message, 'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('Error', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                                });
                        }
                    });
                }
            </script>

            <script>
                function startScan() {
                    document.getElementById("startScanBtn").style.display = "none";
                    document.getElementById("stopScanBtn").style.display = "inline-block";
                    document.getElementById("scanner").style.display = "block";

                    navigator.mediaDevices.getUserMedia({
                            video: true
                        })
                        .then(function(stream) {
                            const scanner = document.getElementById("scanner");
                            scanner.srcObject = stream;
                            scanner.play();

                            Quagga.init({
                                inputStream: {
                                    name: "Live",
                                    type: "LiveStream",
                                    target: scanner,
                                    constraints: {
                                        width: 640,
                                        height: 480,
                                        facingMode: "environment"
                                    }
                                },
                                locator: {
                                    halfSample: true,
                                    patchSize: "medium"
                                },
                                numOfWorkers: 2, // Adjust as needed
                                decoder: {
                                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader"],
                                    multiple: false,
                                    debug: {
                                        drawBoundingBox: true,
                                        showFrequency: true,
                                        drawScanline: true,
                                        showPattern: true
                                    }
                                }
                            }, function(err) {
                                if (err) {
                                    console.error("Quagga initialization error:", err);
                                    Swal.fire('Error', "Could not initialize the barcode scanner. Please check the console for details.", 'error');
                                    stopScan();
                                    return;
                                }
                                Quagga.start();
                            });

                            let scanAttempts = 0;
                            const maxScanAttempts = 3; // Retry scanning up to 3 times

                            Quagga.onDetected(function(result) {
                                if (result && result.codeResult && result.codeResult.code) {
                                    const barcode = result.codeResult.code;
                                    document.getElementById("scanResult").innerText = "Barcode: " + barcode;
                                    stopScan();
                                    processScannedBarcode(barcode);
                                } else {
                                    console.warn("No barcode detected. Attempt:", scanAttempts + 1);
                                    if (scanAttempts < maxScanAttempts) {
                                        scanAttempts++;
                                        setTimeout(() => Quagga.start(), 500); // Retry after 500ms
                                    } else {
                                        Swal.fire('Warning', "Could not detect barcode after multiple attempts. Please try again.", 'warning');
                                        stopScan();
                                    }
                                }
                            });
                        })
                        .catch(function(err) {
                            console.error("Camera access denied:", err);
                            Swal.fire('Error', "Camera access denied. Please allow camera permissions.", 'error');
                            stopScan();
                        });
                }

                function stopScan() {
                    Quagga.stop();
                    const scanner = document.getElementById("scanner");
                    if (scanner) {
                        scanner.pause();
                        if (scanner.srcObject) {
                            scanner.srcObject.getTracks().forEach(track => track.stop());
                        }
                        scanner.srcObject = null;
                    }
                    document.getElementById("scanner").style.display = "none";
                    document.getElementById("startScanBtn").style.display = "inline-block";
                    document.getElementById("stopScanBtn").style.display = "none";
                    document.getElementById("scanResult").innerText = "";
                }

                function processScannedBarcode(barcode) {
                    console.log("processScannedBarcode called with:", barcode);

                    fetch('return_book_barcode.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'barcode=' + encodeURIComponent(barcode)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', data.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error processing barcode:', error);
                            Swal.fire('Error!', 'An error occurred while processing the barcode. Please check the console.', 'error');
                        });
                }
            </script>

</body>

</html>