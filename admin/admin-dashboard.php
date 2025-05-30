<?php
include '../validate/db.php';
require '../vendor/autoload.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
    exit;
}

// Get the total number of users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    $row_users = $result_users->fetch_assoc();
    $total_users = $row_users['total_users'];
} else {
    $total_users = 0;
}

// Get the total number of books and total quantity
$sql_books = "SELECT
                    (SELECT COUNT(*) FROM books) AS total_count_books,
                    (SELECT COUNT(*) FROM library_books) AS total_count_library_books,
                    (SELECT COUNT(*) FROM author_books) AS total_count_author_books,
                    (SELECT SUM(quantity) FROM books) AS total_quantity_books,
                    (SELECT SUM(quantity) FROM library_books) AS total_quantity_library_books,
                    (SELECT SUM(quantity) FROM author_books) AS total_quantity_author_books";

$result_books = $conn->query($sql_books);

if ($result_books->num_rows > 0) {
    $row_books = $result_books->fetch_assoc();
    $total_count_books = $row_books['total_count_books']
        + $row_books['total_count_library_books']
        + $row_books['total_count_author_books'];
    $total_quantity_books = $row_books['total_quantity_books']
        + $row_books['total_quantity_library_books']
        + $row_books['total_quantity_author_books'];
} else {
    $total_count_books = 0;
    $total_quantity_books = 0;
}

// Count complete and incomplete transactions
$sql_transactions = "SELECT
                                SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) AS complete_transactions,
                                SUM(CASE WHEN completed = 0 THEN 1 ELSE 0 END) AS incomplete_transactions
                             FROM transactions";

// Execute the query
$result_transactions = $conn->query($sql_transactions);

if ($result_transactions->num_rows > 0) {
    $row_transactions = $result_transactions->fetch_assoc();
    $complete_transactions = $row_transactions['complete_transactions'];
    $incomplete_transactions = $row_transactions['incomplete_transactions'];
} else {
    $complete_transactions = 0;
    $incomplete_transactions = 0;
}

// Get the current page for pagination of the top 20 books
$page_top20 = isset($_GET['page_top20']) ? (int)$_GET['page_top20'] : 1;
$page_top20 = max($page_top20, 1); // Ensure the page number is at least 1

// Records per page for the top 20 books
$records_per_page_top20 = 10;
$offset_top20 = ($page_top20 - 1) * $records_per_page_top20;

// Query to fetch the top 20 recently added books
$sql_top20_books = "
SELECT CONCAT('B-B-', `id`) AS id, `title`, `author`, `date_added`
FROM `books`

UNION ALL

SELECT CONCAT('B-L-', `id`) AS id, `title`, 'N/A' AS `author`, `date_added`
FROM `library_books`

UNION ALL

SELECT CONCAT('B-A-', `id`) AS id, `title`, `author`, `date_added`
FROM `author_books`

ORDER BY `date_added` DESC
LIMIT 20";

$result_top20_books = $conn->query($sql_top20_books);

$top20_books = [];
if ($result_top20_books->num_rows > 0) {
    while ($row = $result_top20_books->fetch_assoc()) {
        $top20_books[] = $row;
    }
}

// Calculate total pages for the top 20 books
$total_top20_books = count($top20_books);
$total_pages_top20 = ceil($total_top20_books / $records_per_page_top20);

// Get the specific subset of books for the current page
$paged_top20_books = array_slice($top20_books, $offset_top20, $records_per_page_top20);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        /* General styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
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
            padding: 10px 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 60px;
        }

        header .logo-container {
            display: flex;
            align-items: center;
        }

        header .logo-container img {
            width: 80px;
            margin-right: 10px;
        }

        header .logo-container span {
            font-size: 22px;
            font-weight: bold;
        }

        .sidebar img {
            border-radius: 50%;
            width: 80px;
            display: block;
            margin: 30px auto 10px;
        }

        .sidebar h3 {
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
        }

        .sidebar ul a .lucide {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .logout .lucide {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }


        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            height: calc(100vh - 60px);
            width: 250px;
            background-color: #007BFF;
            color: white;
            padding: 20px;
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
            margin: 10px 0;
            padding: 15px;
            background-color: #0056b3;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 16px;
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
            border-left: 5px solid #3498db;
            padding-left: 15px;
        }

        /* Logout Button - Positioned at the Bottom */
        .logout {
            list-style: none;
            position: absolute;
            bottom: 50px;
            /* Offset from the bottom */
            left: 20px;
            /* Offset from the left */
            right: 20px;
            /* Offset from the right */
            display: block;
            padding: 15px;
            background-color: #0056b3;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #004080;
        }

        .logout i {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }


        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 130px;
            box-sizing: border-box;
            min-height: calc(100vh - 60px);
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            margin: 0 10px;
            padding: 20px;
            border-radius: 8px;
            background-color: #007BFF;
            color: white;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-box h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .stat-box p {
            margin: 10px 0 0;
            font-size: 18px;
        }

        .recent-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .recent-table th,
        .recent-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .recent-table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .recent-table tr:hover {
            background-color: #f9f9f9;
        }

        .pagination {
            margin-top: 40px;
            text-align: center;
        }

        .pagination a {
            text-decoration: none;
            color: #007BFF;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 0 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f4f4f4;
        }

        .pagination a.disabled {
            color: #aaa;
            cursor: not-allowed;
        }

        .quanti {
            display: inline;
            font-weight: normal;
        }

        .modern-button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-left: 1430px;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            margin-bottom: -100px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .modern-button:hover {
            background-color:#439a46;
            transform: scale(1.05);
        }

        .modal {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .modal-button {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 15px 30px;
            /* Pinalaki ang padding */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            /* Pinalaki ang font size */
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-button.cancel {
            background-color: red !important;
            padding: 15px 30px;
            /* Pinalaki din ang padding para sa cancel button */
            font-size: 16px;
            /* Pinalaki din ang font size para sa cancel button */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body>
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
            <div class="stats-container">
                <div class="stat-box">
                    <h2><?php echo $total_users; ?></h2>
                    <p>Total Users</p>
                </div>
                <div class="stat-box">
                    <h2><?php echo $total_count_books . " <p class='quanti'>(" . $total_quantity_books . ") </p>"; ?></h2>
                    <p>Total Books</p>
                </div>
                <div class="stat-box">
                    <h2><?php echo $complete_transactions ?></h2>
                    <p>Completed Transactions</p>
                </div>
                <div class="stat-box">
                    <h2><?php echo $incomplete_transactions ?></h2>
                    <p>Incomplete Transactions</p>
                </div>
            </div>

            <div id="confirmationModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <img src="admin-print.png" alt="Export Icon" class="modal-icon">
                    <p>You are about to export all registered users, registered books, and transactions. Do you want to continue?</p>
                    <button id="confirmExportButton" class="modal-button" onclick="redirectToExportReports()">Continue</button>
                    <button class="modal-button cancel" onclick="redirectToDashboard()">Cancel</button>
                </div>
            </div>
            <script>
                function redirectToDashboard() {
                    window.location.href = "admin-dashboard.php";
                }

                function redirectToExportReports() {
                    window.location.href = "export_reports.php";
                }
            </script>

            <button id="printAllReportsButton" class="modern-button">Print All Reports</button>
            <h2 style="margin-top: -20px;">Recently Added Books</h2>

<table class="recent-table">
    <thead>
        <tr>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Date Added</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($paged_top20_books)): ?>
            <tr>
                <td colspan="4" style="text-align: center;">No recently added books found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($paged_top20_books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['id']); ?></td>
                    <td><?php echo htmlspecialchars($book['title']); ?></td>
                    <td><?php echo htmlspecialchars($book['author']); ?></td>
                    <td><?php echo htmlspecialchars($book['date_added']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>

<div class="pagination">
    <?php if ($page_top20 > 1): ?>
        <a href="?page_top20=<?php echo $page_top20 - 1; ?>">← Previous</a>
    <?php else: ?>
        <a class="disabled">← Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $page_top20; ?> of <?php echo $total_pages_top20; ?></span>

    <?php if ($page_top20 < $total_pages_top20): ?>
        <a href="?page_top20=<?php echo $page_top20 + 1; ?>">Next →</a>
    <?php else: ?>
        <a class="disabled">Next →</a>
    <?php endif; ?>
</div>
</div>
</div>

<script>
lucide.createIcons();
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
const printAllButton = document.getElementById('printAllReportsButton');
const modal = document.getElementById('confirmationModal');
const confirmButton = document.getElementById('confirmExportButton');
const cancelButton = document.getElementById('cancelExportButton');

// Function to show the modal
const showModal = () => {
    modal.style.display = 'flex';
};

// Function to hide the modal
const hideModal = () => {
    modal.style.display = 'none';
};

printAllButton.addEventListener('click', showModal);
cancelButton.addEventListener('click', hideModal);

confirmButton.addEventListener('click', () => {
    hideModal();
    window.location.href = 'export_reports.php'; // Navigate to export script
});
});
</script>
</body>

</html>
<?php
// Close the database connection at the very end
$conn->close();
?>