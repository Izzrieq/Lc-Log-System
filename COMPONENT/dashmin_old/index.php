<?php 
    include "../DB/config.php"; 

    //wajib ada setiap page
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

    $img = $_SESSION['img'];
    
    $query = "SELECT stateid, COUNT(lcid) AS total_lcid FROM lcdetails GROUP BY stateid";
    $result = mysqli_query($conn, $query);

    // Prepare data array for chart
    $chartData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $chartData[] = array(
            "stateid" => $row['stateid'],
            "total_lcid" => intval($row['total_lcid'])
        );
    }

    // Convert data to JSON format
    $chartDataJSON = json_encode($chartData);
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- amChart -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

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


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .bg-light-blue {
        background-color: lightblue;
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
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="viewtask.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>View Task</a>
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


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-globe fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total LCID</p>

                                <?php
                                    $dash_totallcid_query = "SELECT * FROM lcdetails";
                                    $dash_totallcid_query_run = mysqli_query($conn, $dash_totallcid_query);

                                    if($category_total = mysqli_num_rows($dash_totallcid_query_run))
                                    {
                                        echo '<h6 class="mb-0">  '.$category_total.'</h6>';
                                    }else{
                                        echo '<h6 class="mb-0">No Data...</h6>';
                                    }
                                
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-users fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Complain</p>
                                <?php
                                    $dash_totalcomplaint_query = "SELECT * FROM complaintbliss";
                                    $dash_totalcomplaint_query_run = mysqli_query($conn, $dash_totalcomplaint_query);

                                    if($category_total = mysqli_num_rows($dash_totalcomplaint_query_run))
                                    {
                                        echo '<h6 class="mb-0">  '.$category_total.'</h6>';
                                    }else{
                                        echo '<h6 class="mb-0">No Data...</h6>';
                                    }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-child fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Today Complain</p>
                                <?php
                                    $dash_todaycomplaint_query = "SELECT * FROM complaintbliss WHERE DATE(date) = DATE(NOW()) ORDER BY id ASC";
                                    $dash_todaycomplaint_query_run = mysqli_query($conn, $dash_todaycomplaint_query);

                                    if($category_total = mysqli_num_rows($dash_todaycomplaint_query_run))
                                    {
                                        echo '<h6 class="mb-0">  '.$category_total.'</h6>';
                                    }else{
                                        echo '<h6 class="mb-0">No Data...</h6>';
                                    }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Add on Function</p>
                                <h6 class="mb-0">Otw</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Worldwide LCID</h6>
                            </div>
                            <div id="chartDiv" style="width: 100%; height: 300px;"></div>
                        </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Complain</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Id</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Customer No.HP</th>
                                    <th scope="col">LC Id</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <?php
                                    $result = mysqli_query($conn,"SELECT * FROM complaintbliss WHERE DATE(date) = DATE(NOW()) ORDER BY id ASC "); 
                                    while ($r = mysqli_fetch_array($result)){
                                    ?>
                                    <td><?php echo $r['id']; ?></td>
                                    <td><?php echo $r['cname']; ?></td>
                                    <td><?php echo $r['cnohp']; ?></td>
                                    <td><?php echo $r['lcid']; ?></td>
                                    <td><?php echo $r['category']; ?></td>
                                    <td><?php echo $r['type']; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Niko</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            </br>
                            Distributed By <a class="border-bottom" href="https://themewagon.com"
                                target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
</body>
        <script>

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

    document.addEventListener("DOMContentLoaded", function() {
    am4core.ready(function() {
        // Create chart instance
        var chart = am4core.create("chartDiv", am4charts.XYChart);

        // Add data
        chart.data = <?php echo $chartDataJSON; ?>;

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "stateid";
        categoryAxis.title.text = "State ID";
        categoryAxis.renderer.labels.template.rotation = 0;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Total LCID";
        valueAxis.min = 5;
        valueAxis.max = 45;

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "total_lcid";
        series.dataFields.categoryX = "stateid";
        series.name = "Total LCID";
        series.columns.template.tooltipText = "State ID: {categoryX}\nTotal LCID: {valueY}";

        // Set the column width
        series.columns.template.width = am4core.percent(40);

        // Set up fade-in animation
        series.columns.template.hiddenState.properties.opacity = 0;
        series.columns.template.showOnInit = true;

        // Trigger the fade-in animation on chart's ready event
        chart.events.on("ready", function() {
            series.columns.each(function(column) {
                column.animate({ property: "opacity", to: 1 }, 1000); // Adjust duration as needed
            });
        });
    });
});

        </script>
</html>