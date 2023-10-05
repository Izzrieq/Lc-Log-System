<?php
session_start();
include "../DB/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    // Check if the user is an admin
    if ($_SESSION['type'] === 'admin') {
        // Delete the task
        $delete_task_query = "DELETE FROM tasks WHERE id = '$task_id'";
        $delete_task_result = mysqli_query($conn, $delete_task_query);

        if ($delete_task_result) {
            // Task deleted successfully
            echo "success";
            exit();
        } else {
            // Error deleting task
            echo "error";
            exit();
        }
    } else {
        // Non-admin users are not authorized to delete tasks
        echo "unauthorized";
        exit();
    }
} else {
    // Invalid request
    echo "invalid";
    exit();
}
?>
