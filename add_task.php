<?php
session_start(); // Start the session
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];

    // Insert new task
    $sql = "INSERT INTO tasks (task_name) VALUES ('$task_name')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Task added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

header("Location: index.php");
exit(); // Ensure no further code is executed
?>