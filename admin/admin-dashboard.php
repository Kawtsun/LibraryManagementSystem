<?php
include '../validate/db.php';
session_start();

// Get the total number of users
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    $row_users = $result_users->fetch_assoc();
    $total_users = $row_users['total_users'];
} else {
    $total_users = 0;
}

// Get the total number of books
$sql_books = "SELECT 
                (SELECT COUNT(*) FROM unified_books) + 
                (SELECT COUNT(*) FROM author_books) AS total_books";
$result_books = $conn->query($sql_books);

if ($result_books->num_rows > 0) {
    $row_books = $result_books->fetch_assoc();
    $total_books = $row_books['total_books'];
} else {
    $total_books = 0;
}

// Get the current page for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure the page number is at least 1

// Records per page and offset calculation
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Get the total number of recently added books for pagination
$sql_count = "
SELECT COUNT(*) AS total_books 
FROM (
    SELECT `id` FROM `books` WHERE `date_added` >= NOW() - INTERVAL 7 DAY
    UNION ALL
    SELECT `id` FROM `library_books` WHERE `date_added` >= NOW() - INTERVAL 7 DAY
    UNION ALL
    SELECT `id` FROM `author_books` WHERE `date_added` >= NOW() - INTERVAL 7 DAY
) AS combined_books";
$result_count = $conn->query($sql_count);
$total_recent_books = $result_count->fetch_assoc()['total_books'];

$total_pages = ceil($total_recent_books / $records_per_page);

// Query to fetch recently added books with pagination
$sql_recent_books = "
SELECT `id`, `title`, `author`, `date_added` 
FROM `books` 
WHERE `date_added` >= NOW() - INTERVAL 7 DAY

UNION ALL

SELECT `id`, `title`, 'N/A' AS `author`, `date_added` 
FROM `library_books` 
WHERE `date_added` >= NOW() - INTERVAL 7 DAY

UNION ALL

SELECT `id`, `title`, `author`, `date_added`
FROM `author_books`
WHERE `date_added` >= NOW() - INTERVAL 7 DAY

ORDER BY `date_added` DESC
LIMIT $records_per_page OFFSET $offset";

$result_recent_books = $conn->query($sql_recent_books);

$recent_books = [];
if ($result_recent_books->num_rows > 0) {
    while ($row = $result_recent_books->fetch_assoc()) {
        $recent_books[] = $row;
    }
}
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
            /* Keeps the header at the top */
            top: 0;
            left: 0;
            /* Spans the full width */
            width: 100%;
            /* Full width of the viewport */
            z-index: 1001;
            /* Ensures it sits above content */
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 60px;
            /* Fixed header height */
        }

        header .logo-container {
            display: flex;
            align-items: center;
        }

        header .logo-container img {
            width: 80px;
            margin-right: 10px;
            /* Space between logo and title */
        }

        header .logo-container span {
            font-size: 22px;
            font-weight: bold;
        }

        /* Sidebar - Fixed Below the Header */
        .sidebar {
            position: fixed;
            /* Locks it to the side */
            top: 60px;
            /* Pushes below the header */
            left: 0;
            height: calc(100vh - 60px);
            /* Full height minus header */
            width: 250px;
            /* Fixed sidebar width */
            background-color: #007BFF;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
            /* Scrollable content if needed */
            z-index: 1000;
            /* Below the header */
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

        .sidebar ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar ul li {
            margin: 10px 0;
            padding: 15px;
            display: flex;
            align-items: center;
            background-color: #0056b3;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, padding-left 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #004080;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .sidebar ul li.active {
            background-color: #004080;
            font-weight: bold;
            color: white;
            border-left: 5px solid #3498db;
            padding-left: 15px;
        }

        .lucide {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            /* Offsets the fixed sidebar */
            padding: 20px;
            padding-top: 130px;
            /* Adds space for the fixed header */
            box-sizing: border-box;
            min-height: calc(100vh - 60px);
            /* Ensures content fits below the header */
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
            margin-top: 20px;
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
            <ul>
                <li class="active">
                    <a href="#">
                        <i class="lucide" data-lucide="home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lucide" data-lucide="users"></i> Registered Users
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lucide" data-lucide="book"></i> Registered Books
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lucide" data-lucide="file-text"></i> Transactions
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="lucide" data-lucide="log-out"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="stats-container">
                <div class="stat-box">
                    <h2><?php echo $total_users; ?></h2>
                    <p>Total Users</p>
                </div>
                <div class="stat-box">
                    <h2><?php echo $total_books; ?></h2>
                    <p>Total Books</p>
                </div>
                <div class="stat-box">
                    <h2>167</h2>
                    <p>Completed Transactions</p>
                </div>
            </div>

            <h2>Recently Added Books</h2>
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
                    <?php if (empty($recent_books)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">No recently added books found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_books as $book): ?>
                            <tr>
                                <td>B-<?php echo htmlspecialchars($book['id']); ?></td>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['date_added']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <!-- Previous button -->
                    <a href="?page=<?php echo $page - 1; ?>">← Previous</a>
                <?php else: ?>
                    <a class="disabled">← Previous</a>
                <?php endif; ?>

                <!-- Current page indicator -->
                <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

                <?php if ($page < $total_pages): ?>
                    <!-- Next button -->
                    <a href="?page=<?php echo $page + 1; ?>">Next →</a>
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
        // Sidebar navigation styling
        const sidebarItems = document.querySelectorAll('.sidebar ul li');
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                sidebarItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>