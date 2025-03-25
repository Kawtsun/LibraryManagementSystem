<?php
// JohnDoe.php
include '../../db.php';

$author = "John Doe";

$sql = "SELECT title FROM author_books WHERE author = '$author'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by <?php echo $author; ?></title>
    <style>
        /* Copy the style from authors.php to here */
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
            width: 75%;
            margin-top: 30px;
            margin-bottom: 30px;
            margin-left: 200px;
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
            justify-content: space-between;
            padding: 10px 20px;
            border-radius: 0;
        }

        header {
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        font-size: 2.1em; /* Increased font size */
        font-weight: 600;
        white-space: nowrap; /* Prevent text wrapping */
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
        align-items: center;
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
        font-size: 20px; /* Increased font size */
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
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
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
            color: white;
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

        /* ... your existing dropdown and other styles ... */
    </style>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="container">
        <section class="book-section">
            <h2>Books by <?php echo $author; ?></h2>
            <div class="book-grid">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="book-item">';
                        echo '<img src="book-icon.png" alt="Book Icon" class="book-icon">';
                        echo '<p class="book-title">' . $row['title'] . '</p>';
                        echo '<form action="transaction.php" method="get">';
                        echo '<input type="hidden" name="book_id" value="' . $row['id'] . '">'; // Assuming you have an 'id' column in author_books
                        echo '<button type="submit" class="borrow-btn">Borrow Book</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No books found by this author.</p>";
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>