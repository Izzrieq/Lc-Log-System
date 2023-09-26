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
                    <a href="viewtask.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>View Task</a>
                    <a href="dates.php" class="nav-item nav-link active"><i class="fa fa-keyboard me-2"></i>Calendar</a>
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

            <div id="calendar" class="p-10 m-10"></div>
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
                                        <label for="event_start_date">Event start</label>
                                        <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="event_end_date">Event end</label>
                                        <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="department">department</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value="<?php echo $user_department; ?>"><?php echo $user_department; ?></option>
                                            <option value="ALL">ALL</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="form-group">
                                        <label for="user_id">User_id</label>
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
<script>

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
</body>
</html>