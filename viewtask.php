<?php
session_start();
include "COMPONENT/DB/config.php"; 
include "COMPONENT/header.php";

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = '../../index.php';</script>";
    exit;
}

$img = $_SESSION['img'];
$fullname = $_SESSION['fullname'];
$type = $_SESSION['type'];
$user_department = $_SESSION['department'];

// // Get notification_id from URL
// if(isset($_GET['notification_id'])) {
//     $notification_id = $_GET['notification_id'];
    
//     // Update notification status to 'read'
//     $update_notification_query = "UPDATE notifications SET status = 'read' WHERE notification_id = '$notification_id'";
//     mysqli_query($conn, $update_notification_query);
// }

// Fetch user's assigned tasks if user is not admin
$tasks = array();
if ($type !== 'admin') {
    $tasks_query = "SELECT * FROM tasks WHERE assigned_to = '$fullname' AND department = '$user_department' ORDER BY date_assigned DESC";
    $tasks_result = mysqli_query($conn, $tasks_query);
    while ($task_row = mysqli_fetch_assoc($tasks_result)) {
        $tasks[] = $task_row;
    }
}

// Fetch all tasks for admins within the same department
if ($type === 'admin') {
    $admin_department = $_SESSION['department'];
    $all_tasks_query = "SELECT * FROM tasks WHERE department = '$admin_department' ORDER BY date_assigned DESC";
    $all_tasks_result = mysqli_query($conn, $all_tasks_query);
    while ($task_row = mysqli_fetch_assoc($all_tasks_result)) {
        $tasks[] = $task_row;
    }
}

$admin_query = "SELECT fullname FROM users WHERE type = 'admin' LIMIT 1"; // Modify this query according to your database schema
$admin_result = mysqli_query($conn, $admin_query);
$admin_row = mysqli_fetch_assoc($admin_result);
$adminName = $admin_row['fullname'];

function getUnreadNotificationCountForAdmin($adminName) {
    // Implement your logic to fetch and return the notification count from the database
    // For example, you could run a query to count unread notifications for the admin
    // and return the count.
    // Replace this with your actual database query.
    return 5; // Example count
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Progress and Tasks</title>

    <!-- tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Template Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>
    input[type="file"] {
    color: transparent;
    }

    @media (max-width: 425px) and (min-width: 320px) {
        body{
            width: 100vw;
        }
    .task-container,
    .grid-cols-4 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }

    .border {
        max-width: 100%;
        margin: 0 auto;
    }

    .grid-cols-4 > * {
        width: 100%;
    }

    .mr-2,
    .ml-2 {
        margin-right: 0;
        margin-left: 0;
    }

    .flex {
        flex-direction: column;
    }

    .justify-betweens {
        justify-content: center;
        align-items: center;
    }
}

    @media (max-width: 575px) and (min-width: 425px) {
        body{
            width: 100vw;
        }
    .task-container,
    .grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .border {
        max-width: 100%;
        margin: 0 auto;
    }

    .grid-cols-4 > * {
        width: 100%;
    }

    .mr-2,
    .ml-2 {
        margin-right: 0;
        margin-left: 0;
    }

    .flex {
        flex-direction: column;
    }

    .justify-betweens {
        justify-content: center;
        align-items: center;
    }
}

@media (max-width: 768px) and (min-width: 575px) {
    body{
            width: 100vw;
        }
    .task-container,
    .grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .border {
        max-width: 100%;
        margin: 0 auto;
    }
    .grid-cols-4 > * {
        width: 100%;
    }
    .mr-2,
    .ml-2 {
        margin-right: 0;
        margin-left: 0;
    }
    .flex {
        flex-direction: column;
    }

    .justify-betweens {
        justify-content: center;
        align-items: center;
    }
}

@media (max-width: 1024px) and (min-width: 768px) {
    body{
            width: 100vw;
        }
    .task-container,
    .grid-cols-4 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .border {
        max-width: 100%;
        margin: 0 auto;
    }
    .grid-cols-4 > * {
        width: 100%;
    }
    .mr-2,
    .ml-2 {
        margin-right: 0;
        margin-left: 0;
    }
    .flex {
        flex-direction: column;
    }

    .justify-betweens {
        justify-content: center;
        align-items: center;
    }
}




@media (max-width: 1439px) and (min-width: 1024px) {
    .task-container,
    .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    .border {
        max-width: 100%;
        margin: 0 auto;
    }
    .grid-cols-4 > * {
        width: 100%;
    }
    .mr-2,
    .ml-2 {
        margin-right: 0;
        margin-left: 0;
    }
    .flex {
        flex-direction: column;
    }

    .justify-betweens {
        justify-content: center;
        align-items: center;
    }
}
@media (min-width: 1440px) {
    .border {
        max-width: 100%;
        margin: 0 auto;
    }
    .grid-cols-4 > * {
        width: 100%;
    }
}
</style>

<body>
    <!-- Content Start -->
    <button class="rounded-md bg-blue-700 text-white text-sm px-3 py-2 m-2" type="back" onclick="history.back()">BACK
        <i class="fa fa-undo" aria-hidden="true"></i>
    </button>
    <div class="py-2">
    <div class="container mx-auto bg-slate-100 border p-1">
        <?php if ($type === 'user') { ?>
        <h2 class="text-xl font-bold mb-2">Your Assigned Tasks: </h2>
        <div class="task-container grid grid-cols-4 gap-4 p-2 ">
            <?php foreach ($tasks as $task) { ?>
                <div class="border border-slate-200 p-4 bg-white">
                <!-- Task details -->
                <span class="block font-semibold">Task Description:</span>
                <span><?php echo $task['task_description']; ?></span>
                <span class="block font-semibold date-assigned">Date Assigned:</span>
                <span class="date-assigned"><?php echo $task['date_assigned']; ?></span>
                <span class="block font-semibold">Department:</span>
                <span><?php echo $task['department']; ?></span>

                <!-- Task file upload form -->
                <div class="mt-2">
                    <form
                        action="upload.php"
                        method="post"
                        enctype="multipart/form-data">
                        <label class="block font-semibold">Upload File:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="w-full">
                        <input type="hidden" name="taskId" value="<?php echo $task['id']; ?>">
                        <button
                            class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
                            type="submit"
                            name="upload">Upload</button>
                    </form>
                </div>

                <!-- Task status buttons -->
                <label class="block font-semibold mt-3">Status:</label>
                <div class="flex justify-betweens">
                    <div class="mt-2 mr-2">
                        <button class="bg-yellow-400 text-white px-4 sm:px-2 py-2 rounded" 
                                onclick="updateStatus(<?php echo $task['id']; ?>, 'pending', this)">Pending</button>

                    </div>
                    <div class="mt-2 ml-2">
                        <button class="bg-green-400 text-white px-4 py-2 rounded" 
                        onclick="updateStatus(<?php echo $task['id']; ?>, 'completed', this)">Completed</button>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
    <?php } elseif ($type === 'admin') { ?>
        <h2 class="text-xl font-bold">Your Staff Task Progress:</h2>
        <div class="w-full grid grid-cols-4 gap-4 p-2">
            <?php foreach ($tasks as $task) { ?>
            <div class="border border-slate-200 p-4 bg-white">
                <!-- Task details -->
                <span class="block font-semibold">Name:</span>
                <span class="uppercase"><?php echo $task['assigned_to']; ?></span>
                <span class="block font-semibold">Task Description:</span>
                <span><?php echo $task['task_description']; ?></span>
                <span class="block font-semibold date-assigned">Date Assigned:</span>
                <span class="date-assigned"><?php echo $task['date_assigned']; ?></span>
                <span class="block font-semibold">Department:</span>
                <span><?php echo $task['department']; ?></span>

                <!-- Check task status for background color -->
                <?php $status = $task['status']; ?>
                <div
                    class="mt-4 <?php echo $status === 'completed' ? 'bg-green-200' : ($status === 'pending' ? 'bg-yellow-200' : ''); ?>">
                    <span class="block font-semibold">Status:</span>
                    <span><?php echo $status; ?></span>
                </div>
                <!-- Delete Task button for admins -->
                <?php if ($type === 'admin') { ?>
                <button
                    class="bg-red-500 text-white px-4 py-2 rounded mt-4"
                    onclick="deleteTask(<?php echo $task['id']; ?>)">Delete Task</button>
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
                    <a href="<?php echo $file['file_name']; ?>" download="<?php echo $file['file_name']; ?>"><?php echo $file['file_name']; ?></a>
                    <?php if ($type === 'admin') { ?>
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded ml-2"
                        onclick="deleteFile(<?php echo $file['id']; ?>)">Delete</button>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
</body>

<script>

function updateStatus(taskId, status, button) {
    console.log("updateStatus called");
    // ... (your existing code)
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Refresh the page after updating status
                alert('Are you sure you want to change this status?')
                location.reload();
            } else {
                alert('Error updating task status');
            }
        }
};    
    xhr.open('POST', 'COMPONENT/FUNCTION/update_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('task_id=' + taskId + '&status=' + status);

    if (status === 'pending') {
    button.parentNode.parentNode.parentNode.style.backgroundColor = '#FFED1C'; // Change to desired color
}

if (status === 'completed') {
    button.parentNode.parentNode.parentNode.style.backgroundColor = '#02A802'; // Change to desired color
}
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
        xhr.open('POST', 'COMPONENT/FUNCTION/delete_file.php', true);
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
        xhr.open('POST', 'COMPONENT/FUNCTION/delete_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('task_id=' + taskId);
    }
}

</script>

</html>