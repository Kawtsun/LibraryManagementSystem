<?php
include '../validate/db.php';
session_start();
// if (isset($_SESSION['admin'])) {
//     echo "Welcome, " . $_SESSION['admin'];
// }


// Query to get the total number of users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the total number of users
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
} else {
    $total_users = 0;
}


// Query to get the total number of books
$sql = "SELECT 
            (SELECT COUNT(*) FROM unified_books) + 
            (SELECT COUNT(*) FROM author_books) AS total_books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the total number of books
    $row = $result->fetch_assoc();
    $total_books = $row['total_books'];
} else {
    $total_books = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Header */
        header {
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 60px;
            margin-right: 10px;
        }

        .system-title {
            font-size: 20px;
            font-weight: bold;
        }

        /* Main Layout */
        .container {
            display: flex;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #007BFF;
            color: white;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            border-radius: 50%;
            width: 80px;
            display: block;
            margin: 0 auto 10px;
        }

        .sidebar h3 {
            text-align: center;
            margin: 15px 0;
            font-size: 18px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
            padding: 15px;
            width: 100%;
            display: flex;
            align-items: center;
            background-color: #0056b3;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
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
            display: flex;
            align-items: center;
            gap: 10px;
            /* Space between icon and text */
        }

        .sidebar ul li.active {
            background-color: #004080;
            /* Darker shade for active link */
            font-weight: bold;
            /* Emphasize active link */
            color: white;
            /* Ensure text remains readable */
            border-left: 5px solid #3498db;
            /* Add a visual indicator on the left */
            padding-left: 15px;
            /* Offset text to account for the border */
        }

        .sidebar ul li.active a {
            color: white;
            /* Keep active link text white */
            text-decoration: none;
        }

        .lucide {
            width: 20px;
            height: 20px;
        }


        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
</head>


<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
            <span class="system-title">AklatURSM Management System</span>
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
                    <p>Registered Books</p>
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
                        <th>Added Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>B1-001</td>
                        <td>Mathematics</td>
                        <td>Andrew Leeos</td>
                        <td>2024-03-03 17:09</td>
                    </tr>
                    <tr>
                        <td>B1-002</td>
                        <td>Science</td>
                        <td>Andrew Leeos</td>
                        <td>2024-03-03 17:09</td>
                    </tr>
                    <tr>
                        <td>B1-003</td>
                        <td>ESP</td>
                        <td>Andrew Leeos</td>
                        <td>2024-03-03 17:09</td>
                    </tr>
                    <tr>
                        <td>B1-004</td>
                        <td>Geometry</td>
                        <td>Andrew Leeos</td>
                        <td>2024-03-03 17:09</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
    <script>
        // Select all sidebar list items
        const sidebarItems = document.querySelectorAll('.sidebar ul li');

        // Add a click event listener to each item
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove the 'active' class from all items
                sidebarItems.forEach(i => i.classList.remove('active'));
                // Add the 'active' class to the clicked item
                this.classList.add('active');
            });
        });
    </script>

</body>

</html>