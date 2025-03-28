<?php
// Include your database connection.
include '../validate/db.php';
session_start();

// Get the search query (if any) by book title.
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : "";

// Define pagination variables.
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $records_per_page;

// Build the search condition.
$searchCondition = "";
if ($searchQuery !== "") {
    $searchQueryEscaped = $conn->real_escape_string($searchQuery);
    $searchCondition = "WHERE title LIKE '%$searchQueryEscaped%'";
}

// Count total matching books across all three tables.
$sql_count = "SELECT COUNT(*) AS total FROM (
    (SELECT id FROM books $searchCondition)
    UNION ALL
    (SELECT id FROM author_books $searchCondition)
    UNION ALL
    (SELECT id FROM library_books $searchCondition)
) AS all_books";
$result_count = $conn->query($sql_count);
$total_books = ($result_count) ? $result_count->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_books / $records_per_page);

// Main UNION Query: Fetch books from all tables with computed availability and prefix.
$sql_books = "
    (
    SELECT id, title, author, subject, publication_year, date_added, quantity,
           IF(quantity > 0, 1, 0) AS isBorrowable,
           'B-B-' AS prefix, 1 AS src_order, 'books' AS source
    FROM books
    $searchCondition
    )
    UNION ALL
    (
        SELECT id, title, author, subject, publication_year, date_added, quantity,
           IF(quantity > 0, 1, 0) AS isBorrowable,
           'B-A-' AS prefix, 3 AS src_order, 'author_books' AS source
        FROM author_books
        $searchCondition
    )
    UNION ALL
    (
        SELECT id, title, NULL AS author, topic AS subject, NULL AS publication_year, date_added, quantity,
            IF(quantity > 0, 1, 0) AS isBorrowable,
            'B-L-' AS prefix, 2 AS src_order, 'library_books' AS source
        FROM library_books
        $searchCondition
    )
    ORDER BY src_order ASC, id ASC
    LIMIT $records_per_page OFFSET $offset
";
$result_books = $conn->query($sql_books);
$books = [];
if ($result_books && $result_books->num_rows > 0) {
    while ($row = $result_books->fetch_assoc()) {
        $books[] = $row;
    }
}
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
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            z-index: 1000;
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

        .modal-content input {
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

        .modal-content input:focus {
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
                <a href="#">
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
            <h2>Registered Books</h2>
            <div class="search-bar-container">
                <div class="search-input-wrapper">
                    <input type="text" id="searchInput" placeholder="Search Books..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <?php if ($searchQuery !== ""): ?>
                        <a href="admin-books.php" class="clear-search">
                            Clear
                        </a>
                    <?php endif; ?>
                    <ul id="suggestions" class="suggestions-list"></ul>
                </div>
                <button id="openAddBookModal" class="add-book-button">
                    Add Book
                </button>
            </div>
            <table class="books-table">
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Subject/Topic</th>
                        <th>Publication Year</th>
                        <th>Date Added</th>
                        <th>Quantity</th>
                        <th>Is Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($books)): ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">No books found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <!-- Display Book ID using computed prefix + id -->
                                <td><?php echo htmlspecialchars($book['prefix'] . $book['id']); ?></td>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($book['subject'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($book['publication_year'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($book['date_added']); ?></td>
                                <td><?php echo htmlspecialchars($book['quantity']); ?></td>
                                <td><?php echo ($book['isBorrowable'] ? "Yes" : "No"); ?></td>
                                <td>
                                    <button class="edit-btn" onclick="openEditBookModal(<?php echo htmlspecialchars(json_encode($book)); ?>)">Edit</button>
                                    <button class="delete-btn" onclick="confirmDelete(<?php echo $book['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo ($searchQuery !== '' ? '&search=' . urlencode($searchQuery) : ''); ?>">← Previous</a>
                <?php else: ?>
                    <a class="disabled">← Previous</a>
                <?php endif; ?>

                <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo ($searchQuery !== '' ? '&search=' . urlencode($searchQuery) : ''); ?>">Next →</a>
                <?php else: ?>
                    <a class="disabled">Next →</a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Add Book Modal -->
        <div id="addBookModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addBookModal').style.display='none'">&times;</span>
                <h2>Add Book</h2>
                <div id="addBookErrorMessages" class="error-box"></div> <!-- Error messages -->
                <form id="addBookForm" method="POST" action="add-book.php">
                    <input type="hidden" name="current_page" value="<?php echo isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1; ?>">

                    <label>Title:</label>
                    <input type="text" name="title" id="addTitle" required>

                    <label>Author:</label>
                    <input type="text" name="author" id="addAuthor">

                    <label>Subject/Topic:</label>
                    <input type="text" name="subject" id="addSubject" required>

                    <label>Publication Year:</label>
                    <input type="number" name="publication_year" id="addPublicationYear" required>

                    <label>Quantity:</label>
                    <input type="number" name="quantity" id="addQuantity" min="0" max="10" required value="5">

                    <!-- Dropdown to select the source table -->
                    <label>Source:</label>
                    <select name="source" id="addSource" required>
                        <option value="books" selected>Books</option>
                        <option value="library_books">Library Books</option>
                        <option value="author_books">Author Books</option>
                    </select>

                    <button type="button" id="addBookBtn">Add Book</button>
                </form>
            </div>
        </div>

        <!-- Edit Book Modal (for editing existing book data) -->
        <div id="editBookModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('editBookModal').style.display='none'">&times;</span>
                <h2>Edit Book</h2>
                <div id="editBookErrorMessages" class="error-box"></div>
                <form id="editBookForm" method="POST" action="edit-book.php">
                    <input type="hidden" name="source" id="editSource">
                    <input type="hidden" name="book_id" id="editBookId">
                    <input type="hidden" name="current_page" value="<?php echo isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1; ?>">
                    <label>Title:</label>
                    <input type="text" name="title" id="editTitle" required>
                    <label>Author:</label>
                    <input type="text" name="author" id="editAuthor">
                    <label>Subject/Topic:</label>
                    <input type="text" name="subject" id="editSubject" required>
                    <label>Publication Year:</label>
                    <input type="number" name="publication_year" id="editPublicationYear" required>
                    <label>Quantity:</label>
                    <input type="number" name="quantity" id="editQuantity" min="0" max="10" required value="5">
                    <button type="button" id="updateBookBtn">Update Book</button>
                </form>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
        <script>
            // Example: Add listeners for search input suggestions here if needed.
            // (This is similar to your admin-users JavaScript.)
            document.addEventListener("DOMContentLoaded", function() {
                const searchInput = document.getElementById("searchInput");
                const suggestionsList = document.getElementById("suggestions");
                if (searchInput) {
                    searchInput.addEventListener("input", function() {
                        const query = this.value.trim();
                        if (query.length > 0) {
                            fetch(`./searchBooks.php?q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(data => {
                                    suggestionsList.innerHTML = "";
                                    if (data.length > 0) {
                                        data.forEach(book => {
                                            const li = document.createElement("li");
                                            li.textContent = book.title;
                                            li.addEventListener("click", function() {
                                                searchInput.value = book.title;
                                                window.location.href = `./admin-books.php?search=${encodeURIComponent(book.title)}`;
                                            });
                                            suggestionsList.appendChild(li);
                                        });
                                    } else {
                                        const li = document.createElement("li");
                                        li.textContent = "No books found";
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
                            window.location.href = `./admin-books.php?search=${encodeURIComponent(this.value.trim())}`;
                        }
                    });
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get references to your input fields and source dropdown
                const addSourceSelect = document.getElementById("addSource");
                const addAuthorInput = document.getElementById("addAuthor");
                const addPublicationYearInput = document.getElementById("addPublicationYear");

                // Function to toggle fields based on selected source
                function toggleFieldsBasedOnSource() {
                    const source = addSourceSelect.value;
                    if (source === "library_books") {
                        // For library_books, disable Author and Publication Year
                        addAuthorInput.disabled = true;
                        addPublicationYearInput.disabled = true;
                        // Optionally, clear the values
                        addAuthorInput.value = "";
                        addPublicationYearInput.value = "";
                    } else {
                        // For books and author_books, enable Author and Publication Year
                        addAuthorInput.disabled = false;
                        addPublicationYearInput.disabled = false;
                    }
                }

                // Listen for changes to the dropdown
                addSourceSelect.addEventListener("change", toggleFieldsBasedOnSource);

                // Call the function once on page load to set the correct field state
                toggleFieldsBasedOnSource();
            });
        </script>

        <script>
            // Open add modal
            document.addEventListener("DOMContentLoaded", function() {
                // Get modal and button elements by their IDs
                const addBookModal = document.getElementById("addBookModal");
                const openAddBookModalBtn = document.getElementById("openAddBookModal");

                // Event listener for opening the Add Book Modal
                if (openAddBookModalBtn) {
                    openAddBookModalBtn.addEventListener("click", function() {
                        addBookModal.style.display = "flex";
                    });
                }

                // Close modal when clicking on a .close element inside the modal
                document.querySelectorAll(".modal .close").forEach(function(btn) {
                    btn.addEventListener("click", function() {
                        // Using closest to ensure we get the parent modal container
                        this.closest(".modal").style.display = "none";
                    });
                });

                // Optionally, close the modal if clicking outside the modal content
                window.addEventListener("click", function(event) {
                    if (event.target.classList.contains("modal")) {
                        event.target.style.display = "none";
                    }
                });

                // --- (Re)binding of other modal-related logic if needed ---
                // For example, if you have code to clear or reset form inputs when a modal is opened,
                // add it here.
            });
        </script>
        <script>
            // Open Edit Modal
            document.addEventListener("DOMContentLoaded", function() {
                // Store a reference to the edit modal.
                const editBookModal = document.getElementById('editBookModal');

                // Global function to open the Edit Book Modal.
                // Call this function with a valid book object, e.g.,
                // { id: 1, source: 'books', title: 'My Book', author: 'Author', subject: 'Fiction', publication_year: 2020, quantity: 5 }
                window.openEditBookModal = function(book) {
                    if (!editBookModal) {
                        console.error("Edit modal element not found");
                        return;
                    }

                    // Show the modal by setting display to "flex".
                    editBookModal.style.display = "flex";

                    // Populate hidden and visible fields.
                    document.getElementById('editBookId').value = book.id;
                    document.getElementById('editSource').value = book.source || "books"; // default to books if missing
                    document.getElementById('editTitle').value = book.title || "";
                    document.getElementById('editAuthor').value = book.author || "";
                    document.getElementById('editSubject').value = book.subject || "";
                    document.getElementById('editPublicationYear').value = book.publication_year || "";
                    document.getElementById('editQuantity').value = book.quantity || "5";
                };

                // Bind close events for the edit modal.
                // Close the modal when clicking on any element with a .close class inside the modal.
                document.querySelectorAll('#editBookModal .close').forEach(function(closeBtn) {
                    closeBtn.addEventListener("click", function() {
                        editBookModal.style.display = "none";
                    });
                });

                // Also close the modal if clicking outside of its content.
                window.addEventListener("click", function(event) {
                    if (event.target === editBookModal) {
                        editBookModal.style.display = "none";
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // ----- Add Book Form Submission -----
                const addBookBtn = document.getElementById("addBookBtn");
                const addBookForm = document.getElementById("addBookForm");
                const addBookErrorMessages = document.getElementById("addBookErrorMessages");

                if (addBookBtn) {
                    addBookBtn.addEventListener("click", function() {
                        // Clear any previous error messages
                        addBookErrorMessages.innerHTML = "";

                        // Create a FormData object from the addBookForm
                        const formData = new FormData(addBookForm);

                        // Send the data via fetch to add-book.php
                        fetch("add-book.php", {
                                method: "POST",
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    // Display error messages
                                    addBookErrorMessages.innerHTML = data.error;
                                } else if (data.success) {
                                    // On success, redirect using the provided URL
                                    window.location.href = data.redirect;
                                }
                            })
                            .catch(error => {
                                // In case of network or other errors
                                addBookErrorMessages.innerHTML = "An error occurred while adding the book.";
                                console.error("Add Book Error:", error);
                            });
                    });
                }
                // ----- Edit Book Form Submission -----
                const updateBookBtn = document.getElementById("updateBookBtn");
                const editBookForm = document.getElementById("editBookForm");
                const editBookErrorMessages = document.getElementById("editBookErrorMessages");

                if (updateBookBtn) {
                    updateBookBtn.addEventListener("click", function() {
                        // Clear any previous error messages
                        editBookErrorMessages.innerHTML = "";

                        // Create a FormData object from the editBookForm
                        const formData = new FormData(editBookForm);

                        // Send the form data via fetch to edit-book.php
                        fetch("edit-book.php", {
                                method: "POST",
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    // Display error messages
                                    editBookErrorMessages.innerHTML = data.error;
                                } else if (data.success) {
                                    // On successful update, redirect to the given URL
                                    window.location.href = data.redirect;
                                }
                            })
                            .catch(error => {
                                // Handle any errors from the fetch operation
                                editBookErrorMessages.innerHTML = "An error occurred while updating the book.";
                                console.error("Edit Book Error:", error);
                            });
                    });
                }
            });
        </script>
        <script>
            // Deleting books
            function confirmDelete(bookId) {
                // Get the current page to maintain pagination context
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#3498db',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the delete-book.php script, passing the book ID and current page
                        window.location.href = `delete-book.php?id=${bookId}&page=${currentPage}`;
                    }
                });
            }
        </script>
        <script>
            // Get the status from the data attribute
            const statusElement = document.getElementById('status-handler');
            const status = statusElement.getAttribute('data-status');

            // Check the status and trigger the appropriate SweetAlert2
            if (status === 'added') {
                Swal.fire({
                    icon: 'success',
                    title: 'Book Added',
                    text: 'The new book was successfully added!',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else if (status === 'edited') {
                Swal.fire({
                    icon: 'success',
                    title: 'Book Updated',
                    text: 'The book details were successfully updated!',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else if (status === 'deleted') {
                Swal.fire({
                    icon: 'success',
                    title: 'Book Deleted',
                    text: 'The book was successfully deleted!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            // Remove the status query parameter from the URL
            const url = new URL(window.location);
            url.searchParams.delete('status');
            window.history.replaceState({}, document.title, url);
        </script>

</body>

</html>