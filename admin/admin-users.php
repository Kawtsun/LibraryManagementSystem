<?php
if (isset($_GET['status'])) {
    echo "<script>";
    if ($_GET['status'] === 'added') {
        echo "showAddUserAlert();";
    } elseif ($_GET['status'] === 'edited') {
        echo "showEditUserAlert();";
    } elseif ($_GET['status'] === 'deleted') {
        echo "showDeleteUserAlert();";
    }
    echo "</script>";
}

include '../validate/db.php';
session_start();



// Get the current page for pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure the page number is at least 1

// Records per page and offset calculation
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Get the total number of users for pagination
$sql_count = "
SELECT COUNT(*) AS total_users 
FROM users";
$result_count = $conn->query($sql_count);
$total_users = $result_count->fetch_assoc()['total_users'];

$total_pages = ceil($total_users / $records_per_page);

// Query to fetch registered users with pagination
$sql_registered_users = "
SELECT user_id, username, email, course, student_id 
FROM users 
ORDER BY user_id ASC
LIMIT $records_per_page OFFSET $offset";

$result_registered_users = $conn->query($sql_registered_users);

$registered_users = [];
if ($result_registered_users->num_rows > 0) {
    while ($row = $result_registered_users->fetch_assoc()) {
        $registered_users[] = $row;
    }
}


// Close the database connection
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

        /* Search Bar and Add User Button */
        .search-bar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar-container input {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        .users-table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        .users-table th,
        .users-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f4f4f4;
        }

        .users-table th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .users-table tr:hover {
            background-color: #f9f9f9;
        }

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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- Add a data attribute to pass the status -->
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
                <a href="#">
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
            <h2>Users</h2>
            <!-- Search Bar and Add User Button -->
            <div class="search-bar-container">
                <input type="text" placeholder="Search Users...">
                <button id="addUserBtn">+ Add User</button>
            </div>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Student ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registered_users)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No registered users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($registered_users as $user): ?>
                            <tr>
                                <td>U-<?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['course']); ?></td>
                                <td><?php echo htmlspecialchars($user['student_id']); ?></td>
                                <td>
                                    <button class="edit-btn" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($user)); ?>)">Edit</button>

                                    <button class="delete-btn" onclick="confirmDelete(<?php echo $user['user_id']; ?>)">Delete</button>
                                </td>
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
    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('addUserModal').style.display='none'">&times;</span>
            <h2>Add User</h2>
            <form id="addUserForm" method="POST" action="add-user.php">
                <input type="hidden" name="current_page" value="<?php echo isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1; ?>">
                <label>Username:</label>
                <input type="text" name="username" required>
                <label>Password:</label>
                <input type="password" name="password" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <label>Course:</label>
                <input type="text" name="course" required>
                <label>Student ID:</label>
                <input type="text" name="student_id" required>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('editUserModal').style.display='none'">&times;</span>
            <h2>Edit User</h2>
            <form id="editUserForm" method="POST" action="edit-user.php">
                <input type="hidden" name="user_id" id="editUserId">
                <input type="hidden" name="current_page" value="<?php echo isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1; ?>">
                <label>Username:</label>
                <input type="text" name="username" id="editUsername" required>
                <label>Email:</label>
                <input type="email" name="email" id="editEmail" required>
                <label>Course:</label>
                <input type="text" name="course" id="editCourse" required>
                <label>Student ID:</label>
                <input type="text" name="student_id" id="editStudentId" required>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>


    <script>
        lucide.createIcons();
    </script>

    <script>
        // Open Add User Modal
        document.getElementById('addUserBtn').onclick = function() {
            document.getElementById('addUserModal').style.display = 'flex';
        };

        // Open Edit User Modal
        function openEditModal(user) {
            const editModal = document.getElementById('editUserModal');
            editModal.style.display = 'flex';

            // Populate the form with user details
            document.getElementById('editUserId').value = user.user_id;
            document.getElementById('editUsername').value = user.username;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editCourse').value = user.course;
            document.getElementById('editStudentId').value = user.student_id;
        }

        function confirmDelete(userId) {
            const currentPage = new URLSearchParams(window.location.search).get('page') || 1; // Get the current page, default to 1

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
                    // Redirect to the delete-user.php script, passing the user ID and current page
                    window.location.href = `delete-user.php?id=${userId}&page=${currentPage}`;
                }
            });
        }


        // Close Modals
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.onclick = function() {
                this.parentElement.parentElement.style.display = 'none';
            };
        });

        // Close Modal When Clicking Outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addUserModal');
            const editModal = document.getElementById('editUserModal');
            if (event.target === addModal) {
                addModal.style.display = 'none';
            }
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        };
    </script>

    <script>
        // Get the status from the data attribute
        const statusElement = document.getElementById('status-handler');
        const status = statusElement.getAttribute('data-status');

        // Check the status and trigger the appropriate SweetAlert2
        if (status === 'added') {
            Swal.fire({
                icon: 'success',
                title: 'User Added',
                text: 'The new user was successfully added!',
                timer: 2000,
                showConfirmButton: false
            });
        } else if (status === 'edited') {
            Swal.fire({
                icon: 'success',
                title: 'User Updated',
                text: 'The user details were successfully updated!',
                timer: 2000,
                showConfirmButton: false
            });
        } else if (status === 'deleted') {
            Swal.fire({
                icon: 'success',
                title: 'User Deleted',
                text: 'The user was successfully deleted!',
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