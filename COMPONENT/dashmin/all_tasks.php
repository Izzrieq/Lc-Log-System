<?php
include "../DB/config.php";

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Retrieve tasks for the user
$getTasksQuery = "SELECT task FROM users WHERE username = '$username'";
$getTasksResult = mysqli_query($conn, $getTasksQuery);
$row = mysqli_fetch_assoc($getTasksResult);
$task = unserialize($row['task']);

// Handle task deletion
if (isset($_GET['delete'])) {
    $taskIndex = $_GET['delete'];
    if (array_key_exists($taskIndex, $task)) {
        unset($task[$taskIndex]);
        $serializedTasks = serialize($task);
        
        // Clear the status for the deleted task
        $task[$taskIndex]['status'] = '';
        
        $updateTasksQuery = "UPDATE users SET task = '$serializedTasks' WHERE username = '$username'";
        mysqli_query($conn, $updateTasksQuery);
        header("Location: all_tasks.php");
        exit;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks</title>
    <!-- Add your CSS styles here -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Conditional styling */
        .not-done {
            background-color: #ccc; /* Grey */
        }

        .in-progress {
            background-color: yellow;
        }

        .done {
            background-color: green;
        }
    </style>
</head>

<body>
    <h2>All Tasks for <?php echo $username; ?></h2>
    <table>
        <thead>
            <tr>
                <th>Due Date</th>
                <th>Task</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <tr class="<?php echo ($task['status'] === 'not done') ? 'not-done' : (($task['status'] === 'in-progress') ? 'in-progress' : 'done'); ?>">
    <td><?php echo $task['due_date']; ?></td> <!-- New line for due date -->
    <td><?php echo $task['task']; ?></td>
    <td><?php echo $task['status']; ?></td>
    <td>
        <a href="?delete=<?php echo $taskIndex; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
    </td>
</tr>
        </tbody>
    </table>

    <!-- Add your JavaScript scripts here -->
</body>

</html>
