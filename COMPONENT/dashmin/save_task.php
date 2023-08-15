<?php
include "../DB/config.php";

// Get the submitted data
$username = $_POST['username'];
$task = $_POST['task'];
$status = $_POST['status'];

// Retrieve existing tasks for the user
$getTasksQuery = "SELECT task FROM users WHERE username = '$username'";
$getTasksResult = mysqli_query($conn, $getTasksQuery);
$row = mysqli_fetch_assoc($getTasksResult);
$existingTasks = unserialize($row['task']);

// Append the new task to the array
$existingTasks[] = ['task' => $task, 'status' => $status];

// Serialize the updated array
$serializedTasks = serialize($existingTasks);

// Update the database record
$updateQuery = "UPDATE users SET task = '$serializedTasks' WHERE username = '$username'";
$updateResult = mysqli_query($conn, $updateQuery);

if ($updateResult) {
    // Success message
    echo "Task saved successfully.";
} else {
    // Error message
    echo "Error saving task: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
