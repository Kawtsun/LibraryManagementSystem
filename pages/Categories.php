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
        max-width: 1200px;
        margin: 60px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        align-self: center;
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
        margin-top: 15px;
    }

    .book-section h2 {
        margin-bottom: 20px;
        color: #333;
        font-size: 2.2em; /* Slightly reduced font size */
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px; /* Reduced gap */
        justify-items: center;
    }

    .book-item {
        background-color: #3498db;
        color: white;
        padding: 20px; /* Reduced padding */
        border-radius: 12px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 230px; /* Reduced width */
        height: 220px; /* Reduced height */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex; /* Added flexbox to ensure vertical alignment */
        flex-direction: column; /* Added flexbox to ensure vertical alignment */
        justify-content: space-between; /* Added flexbox to ensure vertical alignment */
    }

    .book-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .book-icon {
        width: 90px;
        height: 90px;
        margin-bottom: 10px;
    }

    .book-title {
        font-size: 1.4em; /* Adjusted font size */
        font-weight: 600;
        text-decoration: none;
        color: white;
    }

    .see-books-btn {
        background-color: #2ecc71;
        color: white;
        padding: 10px 35px; /* Reduced padding */
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.2em; /* Reduced font size */
        font-weight: 600;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .see-books-btn:hover {
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
                padding: 15px;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="header-left">
            <img src="../img/LMS_logo.png" alt="Library Logo" class="logo">
            <span class="system-title">AklatURSM Management System</span>
        </div>
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Search...">
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li class="dropdown">
                    <a href="categories.php">Categories <span class="down-arrow"></span></a>
                    <div class="dropdown-content">
                        <a href="genre/math.php">Math</a>
                        <a href="genre/english.php">English</a>
                        <a href="genre/science.php">Science</a>
                        <a href="genre/ap.php">Araling Panlipunan</a>
                        <a href="genre/esp.php">Edukasyon Sa Pagpapakatao</a>
                        <a href="genre/physical-education.php">Physical Education</a>
                        <a href="genre/filipino.php">Filipino</a>
                        <a href="genre/tle.php">Technology and livelihood Education</a>
                    </div>
                </li>
                <li><a href="Authors.php">Authors</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <section class="book-section">
            <h2>Categories</h2>
            <div class="book-grid">
                <?php
                $genres = ["Mathematics", "Science", "English", "Filipino", "TLE", "Physical Education", "Araling Panlipunan", "ESP"];
                $icons = [
                    "math-icon.png",
                    "science-icon.png",
                    "english-icon.png",
                    "filipino-icon.png",
                    "tle-icon.png",
                    "pe-icon.png",
                    "ap-icon.png",
                    "esp-icon.png"
                ]; // Array of image filenames

                foreach ($genres as $index => $genre) {
                    switch ($genre) {
                        case "Mathematics":
                            $targetPage = "genre/math.php";
                            break;
                        case "Science":
                            $targetPage = "genre/science.php";
                            break;
                        case "English":
                            $targetPage = "genre/english.php";
                            break;
                        case "Filipino":
                            $targetPage = "genre/filipino.php";
                            break;
                        case "TLE":
                            $targetPage = "genre/tle.php";
                            break;
                        case "Physical Education":
                            $targetPage = "genre/physical-education.php";
                            break;
                        case "Araling Panlipunan":
                            $targetPage = "genre/ap.php";
                            break;
                        case "ESP":
                            $targetPage = "genre/esp.php";
                            break;
                        default:
                            $targetPage = "genre.php?genre=" . urlencode($genre);
                            break;
                    }
                    echo '<div class="book-item">';
                    echo '<a href="' . $targetPage . '" style="text-decoration:none;">';
                    echo '<img src="' . $icons[$index] . '" alt="' . $genre . ' Icon" class="book-icon">';
                    echo '<p class="book-title" style="color:white;">' . $genre . '</p>';
                    echo '<a href="' . $targetPage . '" class="see-books-btn">Explore Books</a>';
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </div>

</body>

</html>