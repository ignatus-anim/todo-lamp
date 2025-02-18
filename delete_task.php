<?php
session_start(); // Start the session
include 'config.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Delete task
    $sql = "DELETE FROM tasks WHERE id='$task_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Task deleted successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

header("Location: index.php");
exit(); // Ensure no further code is executed
?>