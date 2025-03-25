<?php
// math.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematics Books</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        header {
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 0;
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
            font-size: 2.1em;
            font-weight: 600;
            white-space: nowrap;
        }

        .search-container {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: flex-end;
        }

        .search-bar {
            width: 55%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            margin-right: 15px;
        }

        .nav-links {
            display: flex;
            margin-left: auto;
        }

        .nav-links ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links ul li {
            margin-left: 15px;
        }

        .nav-links ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .nav-links ul li a:hover {
            color: #ecf0f1;
        }

        .book-section {
            margin-top: 20px;
        }

        .book-section h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            justify-items: center;
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .book-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .book-title {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .borrow-btn {
            background-color: #2ecc71;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .borrow-btn:hover {
            background-color: #27ae60;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #3498db;
            min-width: 150px;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 6px;
            padding: 8px 0;
        }

        .dropdown-content a {
            color: black;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
            font-size: 15px;
        }

        .dropdown-content a:hover {
            background-color: rgb(30, 90, 131);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .down-arrow {
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #333;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .book-grid {
                grid-template-columns: 1fr;
            }

            .book-item {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <img src="../genre/LMS_logo.png" alt="Library Logo" class="logo">
        <span class="system-title">AklatURSM Management System</span>
    </div>
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Search...">
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="../dashboard.php">Dashboard</a></li>
            <li class="dropdown">
                <a href="../categories.php">Categories <span class="down-arrow"></span></a>
                <div class="dropdown-content">
                    <a href="math.php">Math</a>
                    <a href="english.php">English</a>
                    <a href="science.php">Science</a>
                    <a href="ap.php">Araling Panlipunan</a>
                    <a href="esp.php">Edukasyon Sa Pagpapakatao</a>
                    <a href="physical-education.php">Physical Education</a>
                    <a href="filipino.php">Filipino</a>
                    <a href="tle.php">Technology and livelihood Education</a>
                </div>
            </li>
            <li><a href="../Authors.php">Authors</a></li>
        </ul>
    </div>
</header>

<div class="container">
    <section class="book-section">
        <h2>Genre: Mathematics</h2>
        <div class="book-grid">
            <div class="book-item">
                <img src="../booksicon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">Mathematics Book 1</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="1"> 
                    <button type="submit" class="
                    borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="../booksicon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">Mathematics Book 2</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="2">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="../booksicon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">Mathematics Book 3</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="3">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="../booksicon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">Mathematics Book 4</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="4">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
            <div class="book-item">
                <img src="../booksicon.png" alt="Book Icon" class="book-icon">
                <p class="book-title">Mathematics Book 5</p>
                <form action="transaction.php" method="get">
                    <input type="hidden" name="book_id" value="5">
                    <button type="submit" class="borrow-btn">Borrow Book</button>
                </form>
            </div>
        </div>
    </section>
</div>

</body>
</html>