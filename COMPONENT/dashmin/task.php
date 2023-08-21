<?php
include "../DB/config.php";
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['type'] !== 'admin') {
    echo "<script>alert('You must log in as an admin first.'); window.location.href = 'index.php';</script>";
    exit;
}

// Fetch departments for the dropdown
$departments_query = "SELECT DISTINCT department FROM users";
$departments_result = mysqli_query($conn, $departments_query);

if(isset($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];
    
    // Update notification status to 'read'
    $update_notification_query = "UPDATE notifications SET status = 'read' WHERE id = '$notification_id'";
    mysqli_query($conn, $update_notification_query);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assigned_to = $_POST['assigned_to'];
    $task_description = $_POST['task_description'];
    $assigned_by = $_SESSION['username']; // Capture the username of the admin assigning the task

    // Check if the assigned user is not the same as the assigner
    if ($assigned_to !== $assigned_by) {
        $kuala_lumpur_timezone = new DateTimeZone('Asia/Kuala_Lumpur');
        $date_assigned = new DateTime('now', $kuala_lumpur_timezone);
        $date_assigned_utc = $date_assigned->format('Y-m-d H:i:s'); // Get current UTC time

        // Check if assigned user and assigner are in the same department
        $same_department_query = "SELECT department FROM users WHERE username = '$assigned_to'";
        $same_department_result = mysqli_query($conn, $same_department_query);

        if (mysqli_num_rows($same_department_result) == 1) {
            $department_row = mysqli_fetch_assoc($same_department_result);
            $assigned_to_department = $department_row['department'];

            // Check if the assigner and assigned user are in the same department
            $assigner_department_query = "SELECT department FROM users WHERE username = '$assigned_by'";
            $assigner_department_result = mysqli_query($conn, $assigner_department_query);
            $assigner_department_row = mysqli_fetch_assoc($assigner_department_result);
            $assigner_department = $assigner_department_row['department'];

            if ($assigner_department == $assigned_to_department) {
                // Perform database query to insert the task
                $insert_query = "INSERT INTO tasks (assigned_to, department, task_description, assigned_by, date_assigned) 
                 VALUES ('$assigned_to', '$assigned_to_department', '$task_description', '$assigned_by', '$date_assigned_utc')";

                if (mysqli_query($conn, $insert_query)) {

                    // Insert notification logic
                    $notificationMessage = "You have been assigned a new task: $task_description";

                    // Check if the assigned user exists in the users table
                    $checkUserQuery = "SELECT user_id FROM users WHERE username = '$assigned_to'";
                    $checkUserResult = mysqli_query($conn, $checkUserQuery);

                    if ($checkUserResult && mysqli_num_rows($checkUserResult) == 1) {
                        // User exists, proceed with inserting the notification
                        $userRow = mysqli_fetch_assoc($checkUserResult);
                        $user_id = $userRow['user_id'];

                        $insertNotificationQuery = "INSERT INTO notifications (user_id, message, status, created_at) 
                                VALUES ('$user_id', '$notificationMessage', 'unread', NOW())";

                        if (mysqli_query($conn, $insertNotificationQuery)) {
                            echo "<script>alert('Task assigned successfully.'); window.location.href = 'task.php';</script>";
                        } else {
                            echo "Error inserting notification: " . mysqli_error($conn);
                            echo "User ID: " . $user_id; // Add this line for debugging
                        }
                    } else {
                        // User does not exist, show an error or take appropriate action
                        echo "Error: Assigned user does not exist in the database.";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "<script>alert('You can only assign tasks to users within the same department.'); window.location.href = 'task.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid user selected.'); window.location.href = 'task.php';</script>";
        }
    } else {
        echo "<script>alert('You cannot assign a task to yourself.'); window.location.href = 'task.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
</head>
<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../img/user-icon.png" alt=""
                            style="width: 40px; height: 40px;">
                        <div
                            class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $_SESSION['username']; ?>!</h6>
                        <span><?php echo $_SESSION['department']; ?>(<?php echo $_SESSION['type']; ?>)</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="task.php" class="nav-item nav-link active"><i class="fa fa-th me-2"></i>Task</a>
                    <a href="viewtask.php" class="nav-item nav-link "><i class="fa fa-th me-2"></i>View Task</a>
                    <a href="dates.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Calendar</a>
                    <a href="chart.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Progress</a>
                    <a href="register.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Register</a>
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
                            <img class="rounded-circle me-lg-2" src="../img/user-icon.png" alt=""
                                style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $_SESSION['username']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Home</a>
                            <a href="../FUNCTION/logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

 <!-- Content section -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Assign Task</h6>
            </div>
            <form method="post">
            <div class="mb-3">
    <label for="assigned_to" class="form-label">Assign To</label>
    <select class="form-select" name="assigned_to" id="assigned_to" required>
        <option value="" selected disabled>Select a user</option>
        <?php while ($department_row = mysqli_fetch_assoc($departments_result)) { ?>
            <optgroup label="<?php echo $department_row['department']; ?>">
                <?php
                $users_query = "SELECT username FROM users WHERE department = '{$department_row['department']}'";
                $users_result = mysqli_query($conn, $users_query);
                while ($user_row = mysqli_fetch_assoc($users_result)) {
                    echo "<option value='{$user_row['username']}'>{$user_row['username']}</option>";
                }
                ?>
            </optgroup>
        <?php } ?>
    </select>
</div>
<div class="mb-3">
    <label for="task_description" class="form-label">Task Description</label>
    <textarea class="form-control" name="task_description" rows="3" required></textarea>
</div>
<!-- <div class="mb-3">
    <label for="department" class="form-label">Department</label>
    <input type="text" name="department" id="department" placeholder="-- department --" readonly>
</div> -->
<button type="submit" class="btn btn-primary">Assign Task</button>
            </form>
        </div>
    </div>

    <!-- ... (your footer and scripts) ... -->
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        const assignedToSelect = document.getElementById('assigned_to');
    
    // Get the input element for the department
    const departmentInput = document.getElementById('department');
    
    // Add an event listener to the select element
    assignedToSelect.addEventListener('change', function() {
        // Get the selected option
        const selectedOption = assignedToSelect.options[assignedToSelect.selectedIndex];
        
        // Get the department from the selected option's label
        const department = selectedOption.parentNode.label;
        
        // Update the department input value
        departmentInput.value = department;
    });
    
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

function sendNotification(username, message) {
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
    xhr.send('username=' + encodeURIComponent(username) + '&message=' + encodeURIComponent(message));
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
    var confirmClear = confirm('Are you sure you want to clear all notifications?');
    if (confirmClear) {
        // Perform the action to clear notifications
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the response to get the new notification count and message
                    var response = JSON.parse(xhr.responseText);
                    var newCount = response.count;
                    var newMessage = response.message;

                    // Update the notification count element
                    var notificationCountElement = document.getElementById('notificationCount');
                    notificationCountElement.innerText = newCount;

                    // Display the new message in the dropdown
                    var notificationsDropdown = document.getElementById('notificationsDropdown');
                    notificationsDropdown.innerHTML = newMessage;

                } else {
                    alert('Error clearing notifications');
                }
            }
        };
        xhr.open('POST', 'clear_notifications_read.php', true); // Change the URL to the script that clears notifications
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send();
    }
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
</body>
</html>
