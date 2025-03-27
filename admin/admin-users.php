<?php
include '../validate/db.php';
session_start();

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
                <li class="<?php echo $currentPage === 'admin-dashboard.php' ? 'active' : ''; ?>">
                    <a href="admin-dashboard.php">
                        <i class="lucide" data-lucide="home"></i> Dashboard
                    </a>
                </li>
                <li class="<?php echo $currentPage === 'admin-users.php' ? 'active' : ''; ?>">
                    <a href="admin-users.php">
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

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>