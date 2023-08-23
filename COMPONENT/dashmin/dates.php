<?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
    include "../DB/config.php"; 

    $user_id = $_SESSION['user_id'];
$department = $_SESSION['department'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <script src='fullcalendar-6.1.8/dist/index.global.js'></script>
    <script src='fullcalendar-6.1.8/dist/index.global.min.js'></script>
    <script>
         document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Your calendar configuration here
            initialView: 'dayGridMonth',
            events: 'get_events.php', // Specify the PHP script to fetch events
            eventDisplay: 'block', // Show events as blocks
            eventContent: function(info) {
                return {
                    html: '<b>' + info.event.title + '</b><br>' + info.event.extendedProps.departmentTitle
                };
            }
        });
        calendar.render();
    });
    </script>
</head>
<body>
<h2 class="px-6 mb-0 mt-2 text-primary">WELCOME, <?php echo strtoupper($_SESSION['username']); ?>!<br>
        <h5 class="px-7 text-secondary"><?php echo ($_SESSION['type'])?></h5>
    </h2>
    <div id='calendar'></div>
</body>
</html>
