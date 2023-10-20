<?php
session_start();
include "../DB/config.php"; 

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = '../../index.php';</script>";
    exit;
}
$img = $_SESSION['img'];
$username = $_SESSION['username'];
$type = $_SESSION['type'];
$user_department = $_SESSION['department'];

// Get notification_id from URL
if(isset($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];
    
    // Update notification status to 'read'
    $update_notification_query = "UPDATE notifications SET status = 'read' WHERE notification_id = '$notification_id'";
    mysqli_query($conn, $update_notification_query);
}

// Fetch user's assigned tasks if user is not admin
$tasks = array();
if ($type !== 'admin') {
    $tasks_query = "SELECT * FROM tasks WHERE assigned_to = '$username' AND department = '$user_department' ORDER BY date_assigned DESC";
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

$admin_query = "SELECT username FROM users WHERE type = 'admin' LIMIT 1"; // Modify this query according to your database schema
$admin_result = mysqli_query($conn, $admin_query);
$admin_row = mysqli_fetch_assoc($admin_result);
$adminName = $admin_row['username'];

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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    @media (max-width:425px) {
        .container{
            background-color: blue;
        }
    }
</style>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                </a>
                <div class="flex items-center ms-4 mb-4">
                    <div class="relative">
                        <img class="rounded-full" src="../uploads/<?php echo $img; ?>" alt="User Image" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-full border-2 border-white absolute bottom-0 right-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $_SESSION['username']; ?>!</h6>
                        <span><?php echo $_SESSION['department']; ?>(<?php echo $_SESSION['type']; ?>)</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="viewtask.php" class="nav-item nav-link active"><i class="fa fa-th me-2"></i>View Task</a>
                    <a href="dates.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Calendar</a>
                    <a href="chart.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Progress</a>
                    <?php if ($_SESSION['type'] === 'admin') { ?>
            <a href="task.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Task</a>
            <a href="register.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Register</a>
        <?php } ?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
             <!-- Navbar Start -->
             <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <!-- ... (your existing navbar content) ... -->
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <?php
                                $user_id = $_SESSION['user_id'];
                                $notifications_query = "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC";
                                $notifications_result = mysqli_query($conn, $notifications_query);

                                $unread_notification_count = 0; // Initialize the counter for unread notifications

                                    if (mysqli_num_rows($notifications_result) > 0) {
                                    while ($notification_row = mysqli_fetch_assoc($notifications_result)) {
                                    $notification_status = $notification_row['status'];

                                    if ($notification_status === 'unread') {
                                    $unread_notification_count++; // Increment the counter for unread notifications
                                    }
                                }
                            }
                        ?>
                            <?php if ($unread_notification_count > 0) : ?>
                            <span id="notificationCount" class="badge bg-danger"><?php echo $unread_notification_count; ?></span>
                            <?php endif; ?>
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notification</span>
                            <!-- Display unread notification count -->

                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <!-- Loop through notifications and display them here -->
                            <?php
                                $notifications_result = mysqli_query($conn, $notifications_query);

                                if (mysqli_num_rows($notifications_result) > 0) {
                                    while ($notification_row = mysqli_fetch_assoc($notifications_result)) {
                                    $notification_id = $notification_row['notification_id'];
                                    $notification_message = $notification_row['message'];
                                    $notification_status = $notification_row['status'];
                                    $notification_date = $notification_row['created_at'];
                            ?>
                            <!-- Display individual notifications -->
                            <a href="viewtask.php?notification_id=<?php echo $notification_id; ?>"
                                class="dropdown-item">
                                <div
                                    class="d-flex align-items-center <?php echo $notification_status === 'unread' ? 'bg-light-blue' : ''; ?>">
                                    <i
                                        class="fa fa-bell me-2 text-<?php echo $notification_status === 'unread' ? 'primary' : 'secondary'; ?>"></i>
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0"><?php echo $notification_message; ?></h6>
                                        <small><?php echo $notification_date; ?></small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <?php
                        }
                            } else {
                                echo '<p class="dropdown-item text-center mb-0">No new notifications</p>';
                            }
                                    ?>
                           <a href="#" class="dropdown-item text-center" onclick="clearNotifications()">Clear Notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-full" src="../uploads/<?php echo $img; ?>" alt="User Image" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $_SESSION['username']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="../../home.php" class="dropdown-item">Home</a>
                            <a href="../FUNCTION/logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

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
                        <div class="mt-2">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded"
                                onclick="updateStatus(<?php echo $task['id']; ?>, 'pending')">Pending</button>
                        </div>
                        <div class="mt-2">
                            <button class="bg-green-500 text-white px-4 py-2 rounded"
                                onclick="updateStatus(<?php echo $task['id']; ?>, 'completed')">Completed</button>
                        </div>

                        <!-- Task file upload form -->
                        <form class="mt-4" action="upload.php" method="post" enctype="multipart/form-data">
                            <label class="block font-semibold">Upload File:</label>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="hidden" name="taskId" value="<?php echo $task['id']; ?>">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded mt-2" type="submit"
                                name="upload">Upload</button>
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
                        <span class="block font-semibold">Name:</span>
                        <span><?php echo $task['assigned_to']; ?></span>
                        <span class="block font-semibold">Task Description:</span>
                        <span><?php echo $task['task_description']; ?></span>
                        <span class="block font-semibold">Date Assigned:</span>
                        <span><?php echo $task['date_assigned']; ?></span>
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
                            <button class="bg-red-500 text-white px-4 py-2 rounded mt-4" 
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
                            <a href="<?php echo $file['file_name']; ?>" download><?php echo $file['file_name']; ?></a>
                            <?php if ($type === 'admin') { ?>
                            <button class="bg-red-500 text-white px-4 py-2 rounded ml-2"
                                onclick="deleteFile(<?php echo $file['id']; ?>)">Delete</button>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>

            </div>
</body>
<script>
    <?php
    if ($type === 'admin') {
        ?>
        // Initialize notification count for admins
        var notificationCount = <?php echo getUnreadNotificationCountForAdmin($adminUsername); ?> ;
        var notificationCountElement = document.getElementById('notificationCount');
        notificationCountElement.innerText = notificationCount; <?php
    } ?>
    
function updateStatus(taskId, status) {
    // ... (your existing code)
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

    if (status === 'completed') {
        if ("<?php echo $type; ?>" === 'admin') {
            // Send a notification to admin
            var notificationMessage = "Task #" + taskId +
                " has been marked as completed by user <?php echo $_SESSION['username']; ?>";
            sendNotificationToAdmin(notificationMessage);
        }
    }
}

function sendNotification(name, message) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Notification sent successfully
                // You can optionally handle the response here
            } else {
                alert('Error sending notification');
            }
        }
    };
    xhr.open('POST', 'send_notification.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('Name=' + encodeURIComponent(name) + '&message=' + encodeURIComponent(message));
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
function clearNotifications() {
    var notificationCount = document.getElementById("notificationCount"); // Ensure this line is correct

    // Clear the notification count
    if (notificationCount) {
        notificationCount.innerHTML = '';
    }

    // Perform AJAX request to clear notifications on the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Reload the page or update the notifications dropdown as needed
                // For example: window.location.reload();
            } else {
                console.error('Error clearing notifications:', xhr.statusText);
            }
        }
    };
    xhr.open('GET', 'clear_notifications.php', true);
    xhr.send();
}
    function updateNotificationCount(count) {
        var notificationCountElement = document.getElementById('notificationCount');
        notificationCountElement.innerText = count;
    }

    function sendNotificationToAdmin(message) {
        var adminUsername = "<?php echo $adminUsername; ?>"; // Replace with actual admin username
        sendNotification(adminUsername, message);

        // Update the notification count
        var notificationCountElement = document.getElementById('notificationCount');
        var currentCount = parseInt(notificationCountElement.innerText);
        notificationCountElement.innerText = currentCount + 1;
    }
   
</script>

</html>