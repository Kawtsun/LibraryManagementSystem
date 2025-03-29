<?php
// Include your database connection.
include '../validate/db.php';
session_start();

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
    SELECT t.transaction_id, t.email, t.name, t.book_title, t.date_borrowed, t.return_date,
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

        /* Sidebar - Fixed Below the Header */
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

        /* Sidebar Links - Updated for 'a' Wrapping */
        .sidebar ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

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

        /* Icons inside the links */
        .sidebar ul a .lucide {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 60px;
            box-sizing: border-box;
            min-height: calc(100vh - 60px);
        }

        /* Container for search bar and Add User button */
        .search-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .search-bar-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar-container button:hover {
            background-color: rgb(46, 132, 190);
            transform: scale(1.05);
        }

        /* Wrapper for input and suggestions for relative positioning */
        .search-input-wrapper {
            position: relative;
            width: 300px;
        }

        .search-input-wrapper input {
            padding: 10px 70px 10px 10px;
            /* extra right padding to accommodate the clear button */
            font-size: 16px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Clear Button Styled as a Box */
        .clear-search {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            padding: 0 12px;
            background: #e74c3c;
            color: #fff;
            border: none;
            font-size: 16px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;

            /* Center content vertically and horizontally */
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
            border-radius: 0 0 5px 5px;
            list-style: none;
            margin: 0;
            padding: 0;
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        }

        .suggestions-list li {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions-list li:hover {
            background-color: #f5f5f5;
        }

        .transactions-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .transactions-table th,
        .transactions-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .transactions-table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .transactions-table tr:hover {
            background-color: #f9f9f9;
        }

        /* New Pagination styling as provided */
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

        /* General Button Styling */
        button {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
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
            transform: scale(1.05);
        }

        /* Return Button */
        .return-btn {
            background-color: #2ecc71;
            color: white;
        }

        .return-btn:hover {
            background-color: #28a860;
            transform: scale(1.05);
        }

        /* Delete Button */
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
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
            border-radius: 8px;
            /* Matches the transactions table border radius */
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            /* Increased width for larger display */
            max-height: 80%;
            /* Restrict height to fit viewport */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            /* Matches the transactions table shadow */
            overflow: auto;
            /* Makes content scrollable if it exceeds modal height */
            position: relative;
            text-align: left;
        }

        /* Modal Close Button Styling */
        .close {
            position: absolute;
            top: 16px;
            right: 16px;
            color: #888;
            font-size: 20px;
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
        }

        .modal-content .transactions-table th,
        .modal-content .transactions-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .modal-content .transactions-table th {
            background-color: #007BFF;
            /* Matches table header styling */
            color: white;
            text-transform: uppercase;
        }

        .modal-content .transactions-table tr:hover {
            background-color: #f9f9f9;
        }

        /* Form Fields and Buttons Inside Modals */
        .modal-content label {
            display: block;
            font-weight: bold;
            margin: 12px 0 6px 0;
            /* Adjusted spacing for better layout */
            color: #333;
            /* Darker text for readability */
        }

        .modal-content input,
        select {
            width: 100%;
            /* Full width matching the modal */
            padding: 10px;
            /* Slightly increased padding for comfort */
            margin-top: 6px;
            border: 1px solid #ccc;
            /* Softer border color */
            border-radius: 6px;
            /* Slightly rounded input fields */
            box-sizing: border-box;
            /* Ensures proper width calculation */
        }

        .modal-content input:focus,
        select:focus {
            outline: none;
            border: 1px solid #3498db;
            /* Blue border for focus state */
            box-shadow: 0px 0px 5px rgba(52, 152, 219, 0.5);
            /* Glow effect on focus */
        }

        .modal-content button {
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            /* Slightly rounded button corners */
            cursor: pointer;
            width: 100%;
            /* Full width button */
            font-size: 16px;
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
            padding: 16px;
            /* Extra padding for breathing space */
            border: 1px solid #f5c6cb;
            /* Softer pink border */
            border-radius: 12px;
            /* More rounded corners for a softer look */
            margin-bottom: 20px;
            /* Spacing below the error box */
            display: none;
            /* Hidden by default */
            font-size: 15px;
            /* Slightly larger font for readability */
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
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
            margin-bottom: 10px;
            /* Space between individual errors */
            font-weight: bold;
            /* Highlight each error */
            line-height: 1.6;
            /* Improve readability with better spacing */
        }


        /* Fade-in Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
                /* Slight slide effect */
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <a href="#">
                    <li>
                        <i class="lucide" data-lucide="log-out"></i> Logout
                    </li>
                </a>
            </ul>
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
                <button id="openCompletedTransactions" class="open-completed-button">
                    Open Completed
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
                            </tr>
                        </thead>
                        <tbody id="completedTransactionsBody">
                            <!-- Dynamic rows will be injected here -->
                        </tbody>
                    </table>
                </div>
            </div>


            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Book Title</th>
                        <th>Date Borrowed</th>
                        <th>Return Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No incomplete transactions found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['transaction_id']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['email']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['name']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['book_title']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['date_borrowed']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['return_date']); ?></td>
                                <td>
                                    <button
                                        class="return-btn"
                                        onclick="markAsReturned(<?php echo $transaction['transaction_id']; ?>)">
                                        Return
                                    </button>
                                    <button class="delete-btn" onclick="confirmDelete(<?php echo $book['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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
        </div>

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
                            `;
                                    completedTransactionsBody.appendChild(row);
                                });
                            } else {
                                completedTransactionsBody.innerHTML = '<tr><td colspan="7" style="text-align:center;">No completed transactions found.</td></tr>';
                            }
                        })
                        .catch(error => console.error('Error loading completed transactions:', error));
                }

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
                        fetch('mark-as-returned.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `transaction_id=${transactionId}&source=${source}`
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
</body>

</html>