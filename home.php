<?php 
      include "COMPONENT/DB/config.php"; 
      include "COMPONENT/header.php";
  
      //wajib ada setiap page
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
      if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
          echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
          exit;
      }
  
      $user_id = $_SESSION['user_id'];
      $department = $_SESSION['department'];
      
      // Handle form submission
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $eventName = $_POST["eventName"];
          $eventDate = $_POST["eventDate"];
          $eventTime = $_POST["eventTime"];
  
          // Set the department based on the user's session
          $eventDepartment = $department;
  
          // Check if an event with the same department and date already exists
          $queryCheckDuplicate = "SELECT COUNT(*) FROM events WHERE department = ? AND start_date = ?";
          $stmtCheckDuplicate = $conn->prepare($queryCheckDuplicate);
          $stmtCheckDuplicate->bind_param('ss', $eventDepartment, $eventDate);
          $stmtCheckDuplicate->execute();
          $stmtCheckDuplicate->bind_result($count);
          $stmtCheckDuplicate->fetch();
          $stmtCheckDuplicate->close();
  
          if ($count > 0) {
              echo "<script>alert('An event with the same department and date already exists.');  window.location.href = 'home.php';</script>";
              exit;
          }
  
          // Insert event data into the database
          $queryInsert = "INSERT INTO events (title, start_date, end_date, start_time, department, user_id)
                  VALUES (?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($queryInsert);
          $stmt->bind_param('ssssss', $eventName, $eventDate, $eventDate, $eventTime, $eventDepartment, $user_id);
  
          // Debugging: Output the SQL query
          echo "SQL Query: " . $queryInsert;
  
          if ($stmt->execute()) {
          echo "<script>alert('Event added successfully.');  window.location.href = 'home.php';</script>";
          } else {
              echo "<script>alert('Error adding event: " . $stmt->error . "'); </script>";
          }
      }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal Little Caliphs</title>
    <link rel="icon" type="image/png" href="COMPONENT/img/logolc.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src='fullcalendar-6.1.8/dist/index.global.js'></script>
    <script src='fullcalendar-6.1.8/dist/index.global.min.js'></script>

    <!-- FullCalendar JavaScript -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>

    <!-- tailwindcss -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-neutral-50 mb-5">
    <h2 class="px-6 mb-0 mt-2 text-primary text-2xl">WELCOME, <?php echo ($_SESSION['username']) ?>!<br>
        <h5 class="px-7 text-secondary"><?php echo ($_SESSION['type'])?></h5>
    </h2>

    <h1 class="text-center text-black text-2xl">Our Services</h1>

    <div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">KINDY DETAILS</h5>
                    <p class="card-text">All kindergarten information.</p>
                    <a href="tlcp-data.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">COMPLAINT</h5>
                    <p class="card-text">Getting issue complaint.</p>
                    <a href="bliss-operator.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-red-400">
                    <h5 class="card-title font-bold text-base">Not Active Yet</h5>
                    <p class="card-text">In Progress.</p>
                    <a href="COMPONENT/task-manager/add-task.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">CUSTOMER DETAILS</h5>
                    <p class="card-text">ORBIT</p>
                    <a href="customer-details.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">DASHMIN</h5>
                    <p class="card-text">Task Manager.</p>
                    <a href="bliss-operator.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php echo ($_SESSION['department'])
?>
<div class="mb-8 w-1/3">
    <h3 class="mb-2 text-xl font-semibold">Add Event</h3>
    <form id="addEventForm" method="post" class="space-y-4">
        <div>
            <label for="eventName" class="block text-sm font-medium text-gray-700">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
        </div>
        <div>
            <label for="eventDate" class="block text-sm font-medium text-gray-700">Event Date:</label>
            <input type="date" name="eventDate" id="eventDate" required class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
        </div>
        <div>
            <label for="eventTime" class="block text-sm font-medium text-gray-700">Event Time:</label>
            <input type="time" name="eventTime" id="eventTime" required class="mt-1 form-input block w-full sm:text-sm sm:leading-5">
        </div>
        <!-- Remove the department selection dropdown -->
        <div>
            <!-- Set the department based on the user's session -->
            <input type="hidden" name="eventDepartment" value="<?php echo $department; ?>">
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
        <script>
          document.addEventListener('DOMContentLoaded', function () {
    var containerEl = document.getElementById('calendar');
    new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
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
        events: 'COMPONENT/dashmin/get_events.php', // Specify the PHP script to fetch events
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

        eventReceive: function (info) {
            console.log('Received event:', info);
            // Handle external event drop here
            var confirmation = confirm('Are you sure you want to move this event to ' + info.dateStr + '?');
            if (confirmation) {
                // Handle the external event drop as needed
                // You can access info.draggedEl for the dragged element's details
                var eventTitle = info.draggedEl.innerText.trim();
                var newStartDate = info.dateStr;

                // Send the data to your server using an AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'COMPONENT/dashmin/update_event_date.php', // Adjust the URL
                    data: {
                        title: eventTitle,
                        start_date: newStartDate,
                    },
                    success: function (response) {
                        if (response === "Success") {
                            // External event added successfully
                            // You can render the updated calendar or perform other actions
                            calendar.render();
                        } else {
                            alert('Error adding external event: ' + response);
                        }
                    }
                });
            } else {
                // Revert the drop if canceled
                calendar.getApi().getEventSourceById(info.source.id).remove();
            }
        }
    });

    calendar.render();
});
  
        </script>
</body>
    <?php include "COMPONENT/footer.php" ?>
</html>
