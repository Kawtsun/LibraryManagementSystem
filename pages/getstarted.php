<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AklatURSM - Online Library</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('getstartedBG.gif');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center top;
            color: white; /* Set default text color to white */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: flex-end; /* Align to the right */
            align-items: center;
            padding: 20px;
        }

        .header nav a {
            text-decoration: none;
            color: white; /* Menu items in white */
            margin-left: 20px;
        }

        .content {
            flex-grow: 1; /* Allow content to grow and take remaining space */
            display: flex;
            justify-content: flex-start; /* Align to the left */
            align-items: flex-end; /* Align to the bottom */
            padding: 20px; /* Add padding for spacing */
        }

        .modern-button {
            background-color: #ff9800;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 30px; /* Adjust vertical position */
            margin-left: 60px; /* Adjust horizontal position */
            width: 150px;
            text-align: center;
        }

        .modern-button:hover {
            background-color: #e68a00; /* Darker shade on hover */
        }

        /* Adjust button size for smaller screens */
        @media (max-width: 600px) {
            .modern-button {
                padding: 12px 24px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>

    <div class="content">
        <a href="Dashboard.php" class="modern-button">Get Started</a>
    </div>
</body>
</html>