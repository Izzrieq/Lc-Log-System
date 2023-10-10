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
    $user_id = $_SESSION['user_id'];
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
    <title>Calendar LC</title>

    <!-- tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />

    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<style>
    .event-info {
    color: white;
    /* Add any other styling you need for the event info */
    }
    
    @media (max-width:768px) {
    #calendar {
        margin-left: 0.375rem;
        margin-right: 0.375rem; 
        padding: 0.75rem;
    }

    /* .modal-dialog {
        
    } */
}
</style>

<body>
    <!-- Navbar Start -->
   <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
         <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
               <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                  type="button"
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
                  <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-blue-500">MIN</span>
               </a>
            </div>
            <div class="flex items-center">
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
                  <div
                     class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dropdown-menu"
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
                           <a href="../../home.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                              role="menuitem">Home</a>
                        </li>
                        <li>
                           <a href="../setting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                              role="menuitem">Settings</a>
                        </li>
                        <li>
                           <a href="../FUNCTION/logout.php"
                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">LogOut</a>
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
                  <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
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
                  <svg
                     class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
               <a href="viewtask.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                  <svg
                     class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                     <path
                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                  </svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">View Task</span>
               </a>
            </li>
            <li>
               <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                  <svg
                     class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 24">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 7v6l5.25 3.15.75-1.23L12.25 12 11 7z" />
                  </svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">Progress</span>
               </a>
            </li>
            <li>
               <a href="dates.php" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                  <svg
                     class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
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
                  <svg
                     class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
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
        
            <div id="calendar" class="p-8 mt-12 ml-64"></div>
            <!-- Start popup dialog box -->
            <div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Add New Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">�</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-sm-12">  
                                        <div class="form-group">
                                        <label for="event_name">Event name</label>
                                        <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter your event name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="event_start_date">Event Start</label>
                                        <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="event_end_date">Event End</label>
                                        <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="department">Department</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value="<?php echo $user_department; ?>"><?php echo $user_department; ?></option>
                                            <option value="ALL">ALL</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="user_id">User Id</label>
                                        <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User id" value="<?php echo $user_id; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>

function toggleDropdown() {
      var dropdown = document.getElementById("dropdown-user");
      var currentState = window.getComputedStyle(dropdown).getPropertyValue("display");
      dropdown.style.display = (currentState === "none") ? "block" : "none";
   }

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


        
    //calendar
    $(document).ready(function() {
            display_events();
    });

    function display_events() {
            console.log("display_events function called");
            var events = new Array();
            var calendar = $('#calendar').fullCalendar({
                height: 600,
                defaultView: 'month',
                timeZone: 'local',
                editable: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    console.log("Date selected:", start, end);
                    // Show the popup dialog box when a date is selected
                    $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                    $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                    $('#event_entry_modal').modal('show');
                    // calendar.fullCalendar('unselect'); // Unselect the date after showing the modal
                },
                eventRender: function(event, element, view) {
                    function getEventColor(department) {
                        switch (department) {
                            case "DBD":
                                return "blue"; 
                            case "BLISS":
                                return "green"; 
                            case "AGRO FARM":
                                return "yellow";
                            case "AIM":
                                return "lightblue"; 
                            case "COO OFFICE":
                                return "lightgreen"; 
                            case "EDU":
                                return "orange";
                            case "EMAS":
                                return "blue"; 
                            case "EVERGREEN":
                                return "green"; 
                            case "FINANCE":
                                return "yellow";
                            case "GO WORLD":
                                return "blue"; 
                            case "HR":
                                return "green"; 
                            case "MERCHANDISE":
                                return "yellow";
                            case "OSM":
                                return "blue"; 
                            case "PUBLICATION":
                                return "green"; 
                            case "SUIT":
                                return "yellow";
                            default:
                                return "red"; 
                        }
                    }

                    var leftContent = "<div class='left-content'>";
                    leftContent += "<span class='event-details'>"+"Department: " + event.department + "<br/>"+"Assigned By: " + event.user_id + "</span>";
                    leftContent += "</div>";

                    var rightContent = "<div class='right-content'>";
                    rightContent += "<img src='../img/delete.png' class='delete-icon' data-event-id='" + event.event_id + "' alt='Delete' height='24px' width='24px' />";
                    rightContent += "</div>";

                    element.css('background-color', getEventColor(event.department));
                    element.find('.fc-title').css('color', 'white');

                    // Append left and right content inside the event element
                    element.append(leftContent).append(rightContent);

                    // Style the left and right content for positioning
                    element.find('.left-content').css({
                        color: 'white',
                        float: 'left', // Left-align left content
                        'font-size': '10px',
                        // 'margin': '5px', 
                    });

                    element.find('.right-content').css({
                        float: 'right', // Right-align right content
                    });

                    // Clear floats to ensure proper rendering
                    element.append("<div style='clear:both;'></div>");

                    // Attach a click event handler to the delete icon
                    element.find('.delete-icon').on('click', function() {
                        var eventIdToDelete = $(this).data('event-id');
                        if (confirm("Do you want to delete this event with id = " + event.event_id)) {
                            delete_event(eventIdToDelete);
                        }
                    });
                },
                eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                    // Display confirmation dialog
                    if (confirm("Do you want to update the event date?")) {
                        update_event(event);
                    } else {
                        // Revert the event to its original position
                        revertFunc();
                    }
                }
            });

            $.ajax({
                url: '../FUNCTION/display_event.php',
                dataType: 'json',
                success: function(response) {
                    var result = response.data;
                    $.each(result, function(i, item) {
                        console.log("Department: " + result[i].department);
                        // Check if the event's department matches the user's department or is set to "all"
                        if (result[i].department === '<?php echo $user_department; ?>' || result[i].department === 'ALL') {
                            events.push({
                                event_id: result[i].event_id,
                                title: result[i].title,
                                start: result[i].start,
                                end: result[i].end,
                                department: result[i].department,
                                user_id: result[i].user_id,
                                color: result[i].color,
                            });
                        }
                    });
                    calendar.fullCalendar('addEventSource', events);
                },
                error: function(xhr, status) {
                    alert("Error loading events: " + status);
                }
            });
    }

    function showAddEventModal() {
        // Clear any previous input values
        $('#event_name').val('');
        $('#event_start_date').val('');
        $('#event_end_date').val('');
        populateModalFields(); // Populate department and user_id fields
        $('#event_entry_modal').modal('show');
    }

    function save_event() {
            var event_name = $("#event_name").val();
            var event_start_date = $("#event_start_date").val();
            var event_end_date = $("#event_end_date").val();
            var department = $("#department").val();
            var user_id = $("#user_id").val();

            if (event_name === "" || event_start_date === "" || event_end_date === ""|| department === ""|| user_id === "") {
                alert("Please enter all required details.");
                return false;
            }

            $.ajax({
                url: "../FUNCTION/save_event.php",
                type: "POST",
                dataType: 'json',
                data: {
                    event_name: event_name,
                    event_start_date: event_start_date,
                    event_end_date: event_end_date,
                    department: department,
                    user_id: user_id,
                    // Add more form field data here if needed
                },
                success: function(response) {
                    $('#event_entry_modal').modal('hide');
                    if (response.status === true) {
                        alert(response.msg);
                        location.reload();
                    } else {
                        alert(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('ajax error = ' + error);
                    alert("Error: " + error);
                }
            });

            return false;
    }

    function update_event(event) {
            var event_id = event.event_id;
            var event_start_date = event.start.format('YYYY-MM-DD');

            $.ajax({
                url: '../FUNCTION/update_event.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    event_id: event_id,
                    event_start_date: event_start_date
                },
                success: function(response) {
                    if (response.status === true) {
                        alert(response.msg);
                    } else {
                        alert(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('ajax error = ' + error);
                    alert("Error: " + error);
                }
            });
    }

    function delete_event(event) {
        // Verify that event.id is correctly set before making the AJAX request
        var eventIdToDelete = event;
            if (eventIdToDelete) {
                console.log("Event ID to delete:", eventIdToDelete);

                // Send an AJAX request to delete the event by its ID
                $.ajax({
                    url: '../FUNCTION/delete_event.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        event_id: eventIdToDelete
                    },
                    success: function(response) {
                        if (response.status === true) {
                            alert(response.msg);
                            if (response.refresh === true) {
                                window.location.reload(); // Refresh the page
                            }
                        } else {
                            alert(response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('ajax error = ' + error);
                        alert("Error: " + error);
                    }
                });
            } else {
                console.log("Invalid event ID. Cannot delete.");
            }
    }
   
</script>
</html>