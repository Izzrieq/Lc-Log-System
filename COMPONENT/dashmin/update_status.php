<?php
session_start();
include "../DB/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id']) && isset($_POST['status'])) {
    $taskId = $_POST['task_id'];
    $status = $_POST['status'];
    
    // Update task status
    $updateQuery = "UPDATE tasks SET status = '$status' WHERE id = '$taskId'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Task status updated successfully.";
    } else {
        echo "Error updating task status: " . mysqli_error($conn);
    }
}
?>
