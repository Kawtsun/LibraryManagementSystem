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

        .books-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .books-table th,
        .books-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .books-table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .books-table tr:hover {
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

        /* Edit Button */
        .edit-btn {
            background-color: #2ecc71;
            color: white;
        }

        .edit-btn:hover {
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
            background-color: #f9f9f9;
            /* Softer background for better aesthetics */
            border-radius: 12px;
            /* Slightly more rounded corners */
            padding: 24px;
            width: 400px;
            /* Fixed width for modal */
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.25);
            /* Enhanced shadow for depth */
            position: relative;
            text-align: left;
        }

        /* Close Button Styling */
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

            </div>

        <script>
            lucide.createIcons();
        </script>
</body>

</html>