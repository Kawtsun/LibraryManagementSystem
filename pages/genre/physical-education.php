<?php
// categories.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Categories</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            border-radius: 0;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .search-bar {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .logo {
            width: 80px;
            /* height: 50px; */
            /* background-color: #eee; */
            margin-right: 20px;
        }

        nav {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: right;
        }

        nav ul li {
            display: inline-block;
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .book-section {
            margin-top: 20px;
        }

        .book-section h2 {
            margin-bottom: 10px;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 20px;
            border-radius: 12px;
            /* Slightly rounded corners */
            text-align: center;
            width: 150px;
            /* Set equal width */
            height: 150px;
            /* Set equal height to make it a square */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Add some depth */
        }


        .book-item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .book-item a {
            display: block;
            text-decoration: none;
            color: white;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
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

        .book-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 30px;
            /* Adjust spacing between items */
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .book-item {
            background-color: #3498db;
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            width: 140px;
            height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            justify-content: start;
            /* Aligns grid items to the left */
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
        </div>
        <input type="text" class="search-bar" placeholder="Search...">
    </header>

    <nav>
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
    </nav>

    <div class="container">
        <section class="book-section">
            <h2>Genre: Physical Education</h2>
            <div class="book-grid">
                <div class="book-item">
                    <a href="book1.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 1</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book2.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 2</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book3.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 3</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book4.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 4</p>
                    </a>
                </div>
                <div class="book-grid">
                    <div class="book-item">
                        <a href="book5.php">
                            <img src="book-icon.png" alt="Book Icon">
                            <p>Physical Education 5</p>
                        </a>
                    </div>


        </section>
    </div>

    <div class="container">
        <section class="book-section">
            <div class="book-grid">
                <div class="book-item">
                    <a href="book6.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 6</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book7.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 7</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book8.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 8</p>
                    </a>
                </div>
                <div class="book-item">
                    <a href="book9.php">
                        <img src="book-icon.png" alt="Book Icon">
                        <p>Physical Education 9</p>
                    </a>
                </div>
                <div class="book-grid">
                    <div class="book-item">
                        <a href="book10.php">
                            <img src="book-icon.png" alt="Book Icon">
                            <p>Physical Education 10</p>
                        </a>
        </section>
    </div>



</body>

</html>