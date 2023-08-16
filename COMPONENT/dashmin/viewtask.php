<?php
session_start();
include "../DB/config.php"; 

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = '../../index.php';</script>";
    exit;
}

$username = $_SESSION['username'];
$type = $_SESSION['type'];
$user_department = $_SESSION['department'];

// Fetch user's assigned tasks if user is not admin
$tasks = array();
if ($type !== 'admin') {
    $tasks_query = "SELECT * FROM tasks WHERE assigned_to = '$username' AND department = '$user_department'";
    $tasks_result = mysqli_query($conn, $tasks_query);
    while ($task_row = mysqli_fetch_assoc($tasks_result)) {
        $tasks[] = $task_row;
    }
}

// Fetch all tasks for admins within the same department
if ($type === 'admin') {
    $admin_department = $_SESSION['department'];
    $all_tasks_query = "SELECT * FROM tasks WHERE department = '$admin_department'";
    $all_tasks_result = mysqli_query($conn, $all_tasks_query);
    while ($task_row = mysqli_fetch_assoc($all_tasks_result)) {
        $tasks[] = $task_row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Progress and Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

    <?php if ($type === 'user') { ?>
    <h2 class="text-xl font-bold mb-2">Your Assigned Tasks:</h2>
    <div class="grid grid-cols-4 gap-4">
        <?php foreach ($tasks as $task) { ?>
            <div class="border p-4">
                <!-- Task details -->
                <span class="block font-semibold">Task Description:</span>
                <span><?php echo $task['task_description']; ?></span>
                <span class="block font-semibold">Date Assigned:</span>
                <span><?php echo $task['date_assigned']; ?></span>
                <span class="block font-semibold">Department:</span>
                <span><?php echo $task['department']; ?></span>
                
                <!-- Task status buttons -->
                <div class="mt-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="updateStatus(<?php echo $task['id']; ?>, 'pending')">Pending</button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="updateStatus(<?php echo $task['id']; ?>, 'completed')">Completed</button>
                </div>
                
                <!-- Task file upload form -->
                <form class="mt-4" action="upload.php" method="post" enctype="multipart/form-data">
                    <label class="block font-semibold">Upload File:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="hidden" name="taskId" value="<?php echo $task['id']; ?>">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit" name="upload">Upload</button>
                </form>
            </div>
        <?php } ?>
    </div>
    <?php } elseif ($type === 'admin') { ?>
    <h2 class="text-xl font-bold mb-2">All User Task Progress:</h2>
    <div class="grid grid-cols-4 gap-4">
    <?php foreach ($tasks as $task) { ?>
    <div class="border p-4">
        <!-- Task details -->
        <span class="block font-semibold">Username:</span>
        <span><?php echo $task['assigned_to']; ?></span>
        <span class="block font-semibold">Task Description:</span>
        <span><?php echo $task['task_description']; ?></span>
        <span class="block font-semibold">Date Assigned:</span>
        <span><?php echo $task['date_assigned']; ?></span>
        <span class="block font-semibold">Department:</span>
        <span><?php echo $task['department']; ?></span>
        
        <!-- Check task status for background color -->
        <?php $status = $task['status']; ?>
        <div class="mt-4 <?php echo $status === 'completed' ? 'bg-green-200' : ($status === 'pending' ? 'bg-yellow-200' : ''); ?>">
            <span class="block font-semibold">Status:</span>
            <span><?php echo $status; ?></span>
        </div>
                <!-- Delete Task button for admins -->
                <?php if ($type === 'admin') { ?>
            <button class="bg-red-500 text-white px-4 py-2 rounded mt-4" onclick="deleteTask(<?php echo $task['id']; ?>)">Delete Task</button>
        <?php } ?>

        
        <!-- Task file details -->
        <?php
        $task_id = $task['id'];
        $file_query = "SELECT * FROM task_files WHERE task_id = $task_id";
        $file_result = mysqli_query($conn, $file_query);
        $files = mysqli_fetch_all($file_result, MYSQLI_ASSOC);
        ?>
        <?php foreach ($files as $file) { ?>
            <div class="mt-4">
                <span class="block font-semibold">File:</span>
                <a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo $file['file_name']; ?></a>
                <?php if ($type === 'admin') { ?>
                    <button class="bg-red-500 text-white px-4 py-2 rounded ml-2" onclick="deleteFile(<?php echo $file['id']; ?>)">Delete</button>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
    </div>
    <?php } ?>

    <!-- ... (remaining code) ... -->

</div>
</body>
<script>
    function updateStatus(taskId, status) {
        // Use AJAX to update task status
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Refresh the page after updating status
                    location.reload();
                } else {
                    alert('Error updating task status');
                }
            }
        };
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('task_id=' + taskId + '&status=' + status);
    }

    function deleteFile(fileId) {
        var confirmDelete = confirm('Are you sure you want to delete this file?');
        if (confirmDelete) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Refresh the page after deleting file
                        location.reload();
                    } else {
                        alert('Error deleting file');
                    }
                }
            };
            xhr.open('POST', 'delete_file.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('file_id=' + fileId);
        }
    }
    function deleteTask(taskId) {
        var confirmDelete = confirm('Are you sure you want to delete this task?');
        if (confirmDelete) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Check the response from the server
                        if (xhr.responseText === "success") {
                            // Task deleted successfully
                            location.reload();
                        } else {
                            // Error deleting task
                            alert('Error deleting task');
                        }
                    } else {
                        alert('Error deleting task');
                    }
                }
            };
            xhr.open('POST', 'delete_task.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('task_id=' + taskId);
        }
    }
</script>
</html>
