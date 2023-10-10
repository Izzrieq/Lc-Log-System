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
   .dropdown-container {
      position: relative;
   }

   .dropdown-menu {
      position: absolute;
      top: 100%;
      /* Position the dropdown below the navbar */
      right: 0rem;
      display: none;
      min-width: 12rem;
      padding: 0.5rem 0;
      margin: 0.125rem 0 0;
      font-size: 0.875rem;
      color: #1a202c;
      text-align: left;
      list-style-type: none;
      background-color: #ffffff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 0.375rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
   }

   @media (max-width:425px) {
      .border-2 {
         margin-bottom: 1rem;
      }
   }
</style>

<body>

    <!-- Navbar Start -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="index.php" class="flex ml-2 md:mr-24">
                        <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap "># DASH</span>
                        <span
                            class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-blue-500">MIN</span>
                    </a>
                </div>
                <div class="flex items-center">
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
                    <div class="flex items-center ml-3 dropdown-container">
                        <div>
                            <button type="button" class="flex text-sm rounded-full" aria-expanded="false"
                                onclick="toggleDropdown()">
                                <span class="pr-2 mt-1 font-bold uppercase hover:text-blue-500 flex items-center ">
                                    <?php echo $_SESSION['username']; ?>
                                </span>
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="../uploads/<?php echo $img; ?>" alt="User Image">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dropdown-menu"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none">

                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    <span><?php echo $_SESSION['department']; ?></span>
                                    <span>(<?php echo $_SESSION['type']; ?>)</span>
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="../../home.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Home</a>
                                </li>
                                <li>
                                    <a href="../setting.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="../FUNCTION/logout.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">LogOut</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Start -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="index.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="task.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                            <path
                                d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z" />
                            <path
                                d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Task Manager</span>
                    </a>
                </li>
                <li>
                    <a href="viewtask.php"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 18">
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">View Task</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 7v6l5.25 3.15.75-1.23L12.25 12 11 7z" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Progress</span>
                    </a>
                </li>
                <li>
                    <a href="dates.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M 4 2 C 2.89543 2 2 2.89543 2 4 L 2 20 C 2 21.1046 2.89543 22 4 22 L 20 22 C 21.1046 22 22 21.1046 22 20 L 22 4 C 22 2.89543 21.1046 2 20 2 L 16 2 L 16 0 L 14 0 L 14 2 L 10 2 L 10 0 L 8 0 L 8 2 L 4 2 z M 4 4 L 8 4 L 8 6 L 16 6 L 16 4 L 20 4 L 20 8 L 4 8 L 4 4 z M 4 10 L 20 10 L 20 20 L 4 20 L 4 10 z" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="../../register.php"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Register</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!-- Content Start -->
    <div class="container p-4 mt-12 ml-64">
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
        <h2 class="text-xl font-bold mb-2">Your Staff Task Progress:</h2>
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