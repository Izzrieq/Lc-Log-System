<?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
    
    include "../DB/config.php"; 
    
    $user_id = $_SESSION['user_id'];
    $department = $_SESSION['department'];
    
    // Fetch departments from the database
    $departments = array();
    $queryDepartments = "SELECT DISTINCT department_name FROM departments";
    $resultDepartments = $conn->query($queryDepartments);
    while ($row = $resultDepartments->fetch_assoc()) {
        $departments[] = $row['department_name'];
    }
    
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventName = $_POST["eventName"];
        $eventDate = $_POST["eventDate"];
        $eventTime = $_POST["eventTime"];
        $eventDepartment = $_POST["eventDepartment"];

        // Check if an event with the same department and date already exists
        $queryCheckDuplicate = "SELECT COUNT(*) FROM events WHERE department = ? AND start_date = ?";
        $stmtCheckDuplicate = $conn->prepare($queryCheckDuplicate);
        $stmtCheckDuplicate->bind_param('ss', $eventDepartment, $eventDate);
        $stmtCheckDuplicate->execute();
        $stmtCheckDuplicate->bind_result($count);
        $stmtCheckDuplicate->fetch();
        $stmtCheckDuplicate->close();

        if ($count > 0) {
            echo "<script>alert('An event with the same department and date already exists.');  window.location.href = 'dates.php';</script>";
            exit;
        }

        // Insert event data into the database
        $queryInsert = "INSERT INTO events (title, start_date, end_date, start_time, department, user_id)
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($queryInsert);
        $stmt->bind_param('sssssi', $eventName, $eventDate, $eventDate, $eventTime, $eventDepartment, $user_id);
        if ($stmt->execute()) {
            echo "<script>alert('Event added successfully.');  window.location.href = 'dates.php';</script>";
        } else {
            echo "<script>alert('Error adding event.');  window.location.href = 'dates.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src='fullcalendar-6.1.8/dist/index.global.js'></script>
    <script src='fullcalendar-6.1.8/dist/index.global.min.js'></script>

    <!-- FullCalendar JavaScript -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>

    <!-- tailwindcss -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    var containerEl = document.getElementById('calendar');
    new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText.trim(),
                start: moment().format('YYYY-MM-DD') // Set a default start date
            };
        }
    });

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Your calendar configuration here
        initialView: 'dayGridMonth',
        events: 'get_events.php', // Specify the PHP script to fetch events
        eventDisplay: 'block', // Show events as blocks

        eventContent: function (info) {
    if (info.event) {
        var eventTitle = info.event.title;
        var startTime = eventTitle.substring(eventTitle.lastIndexOf('(') + 1, eventTitle.lastIndexOf(')'));
    
        return {
            html: '<b>' + info.event.title + '</b><br>' +
                  'Time: ' + startTime + '<br>' +
                  'Department: ' + (info.event.extendedProps ? info.event.extendedProps.departmentTitle : 'N/A')
        };
    } else {
        return null; // or an appropriate fallback
    }
},
        editable: true, // Enable editing of events
        droppable: true, // Enable drag-and-drop for adding events

        drop: function (info) {
            var confirmation = confirm('Are you sure you want to move this event to ' + info.dateStr + '?');
            if (confirmation) {
                var eventID = info.event.extendedProps.event_id; // Use the correct field name
                var newStartDate = info.dateStr;

                $.ajax({
                    type: 'POST',
                    url: 'update_event_date.php',
                    data: {
                        eventID: eventID,
                        newStartDate: newStartDate
                    },
                    success: function (response) {
                        if (response === "Success") {
                            // Event date updated successfully in the database
                            // Render the updated calendar
                            calendar.render();
                        } else {
                            alert('Error updating event date.');
                        }
                    }
                });
            } else {
                info.revert();
            }
        }
    });

    calendar.render();
});


    </script>
</head>
<body class="bg-gray-100">
    <div class="p-6">
        <h2 class="mb-2 text-2xl font-semibold text-primary">WELCOME, <?php echo strtoupper($_SESSION['username']); ?>!</h2>
        <h5 class="mb-4 text-sm text-secondary"><?php echo ($_SESSION['type'])?></h5>
        <div class="mb-8 w-1/3">
            <h3 class="mb-2 text-xl font-semibold">Add Event</h3>
            <form id="addEventForm" method="post" class="space-y-4">
                <div>
                    <label for="eventName" class="block text-sm font-medium text-gray-700">Event Name:</label>
                    <input type="text" id="eventName" name="eventName" required
                           class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
                </div>
                <div>
                    <label for="eventDate" class="block text-sm font-medium text-gray-700">Event Date:</label>
                    <input type="date" name="eventDate" id="eventDate" required
                    class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
                </div>
                <div>
                    <label for="eventTime" class="block text-sm font-medium text-gray-700">Event Time:</label>
                    <input type="time" name="eventTime" id="eventTime" required
                    class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
                </div>
                <div>
                    <label for="eventDepartment" class="block text-sm font-medium text-gray-700">Department:</label>
                    <select id="eventDepartment" name="eventDepartment"
                            class="mt-1 form-select block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm sm:leading-5">
                            <option value="" selected required disabled>--SELECTED--</option>
                        <?php foreach ($departments as $department) { ?>
                            <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-primary bg-primary hover:bg-primary-dark active:bg-primary-darker focus:outline-none focus:border-primary focus:ring focus:ring-primary transition ease-in-out duration-150">
                        Add Event
                    </button>
                </div>
            </form>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="mb-2 text-xl font-semibold">Calendar</h3>
            <div id="calendar"></div>
        </div>
    </div>
</body>
</html>
