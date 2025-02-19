<?php
session_start(); // Start the session
include 'config.php';

// Fetch all tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .message {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        li form {
            margin: 0;
        }
        li a {
            color: #dc3545;
            text-decoration: none;
        }
        li a:hover {
            text-decoration: underline;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>ToDo App</h1>

    <!-- Display success or error messages -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']); // Clear the message after displaying
    }
    if (isset($_SESSION['error'])) {
        echo "<div class='error'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']); // Clear the error after displaying
    }
    ?>

    <!-- Form to add a new task -->
    <form action="add_task.php" method="POST">
        <input type="text" name="task_name" placeholder="Enter a new task" required>
        <button type="submit">Add Task</button>
    </form>

    <!-- Display tasks -->
    <h2>Tasks</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<form action='complete_task.php' method='POST' style='display:inline;'>";
                echo "<input type='hidden' name='task_id' value='" . $row['id'] . "'>";
                echo "<input type='checkbox' name='is_completed' onchange='this.form.submit()'" . ($row['is_completed'] ? " checked" : "") . ">";
                echo "</form>";
                echo htmlspecialchars($row['task_name']);
                echo " <a href='delete_task.php?task_id=" . $row['id'] . "'>Delete</a>";
                echo "</li>";
            }
        } else {
            echo "<li>No tasks found.</li>";
        }
        ?>
    </ul>
</body>
</html>