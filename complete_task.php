<?php
session_start(); // Start the session
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $is_completed = isset($_POST['is_completed']) ? 1 : 0;

    // Update task status
    $sql = "UPDATE tasks SET is_completed='$is_completed' WHERE id='$task_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Task updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

header("Location: index.php"); // Redirect back to the main page
exit(); // Ensure no further code is executed
?>