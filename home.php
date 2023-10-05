<?php 
    include "COMPONENT/DB/config.php"; 
    include "COMPONENT/header.php";

    // Make sure there's an active session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $userDepartment = $_SESSION['department'];
    $username = $_SESSION['username'];
    $type = $_SESSION['type'];
    
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventName = $_POST["event_name"];
        $eventStartDate = $_POST["event_start_date"];
        $eventEndDate = $_POST["event_end_date"];
        $eventTime = $_POST["event_time"];

        // Set the department based on the user's session
        $eventDepartment = $department;

        // Check if an event with the same department and date already exists
        $queryCheckDuplicate = "SELECT COUNT(*) FROM events WHERE department = ? AND start_date = ?";
        $stmtCheckDuplicate = $conn->prepare($queryCheckDuplicate);
        $stmtCheckDuplicate->bind_param('ss', $eventDepartment, $eventStartDate);
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
        $stmt->bind_param('ssssss', $eventName, $eventStartDate, $eventEndDate, $eventTime, $eventDepartment, $user_id);

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

    <!-- tailwindcss -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- bootstrap css and js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<style>
    .event-info {
    color: white;
    /* Add any other styling you need for the event info */
}
</style>

<body class="bg-neutral-50 mb-5">
    <h2 class="px-6 mb-0 mt-2 text-primary text-2xl">WELCOME, <?php echo $username ?>!<br>
        <h5 class="px-7 text-secondary"><?php echo $type?></h5>
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
                    <h5 class="card-title font-bold text-base">TASK MANAGER</h5>
                    <p class="card-text">Assign Task</p>
                    <a href="COMPONENT/dashmin_v2/task.php" class="btn btn-primary mt-2">Go Somewhere</a>
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
                    <a href="COMPONENT/dashmin_v2/index.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">CALLER</h5>
                    <p class="card-text">IN PROGRESS</p>
                    <input class="btn btn-info text-white mt-2 w-full" type="text" id="caller-id" name="caller-id"/>
                    <div id="suggestions" style="display: none;">
                        <ul id="suggestion-list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
<h3 class="mb-0 ml-5 text-lg">Weekly Event | <a class="text-decoration-none" href="COMPONENT/dashmin v2/dates.php">Show more...</a></h3>
<div id="calendar" class="my-5 p-10 mt-0"></div>
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
                                <option value="<?php echo $userDepartment; ?>"><?php echo $userDepartment; ?></option>
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
<!-- End popup dialog box -->

</body>
<script>

// JavaScript to handle user input and fetch suggestions
document.getElementById('caller-id').addEventListener('keyup', function () {
    const userInput = this.value.trim(); // Get the user's input and trim whitespace
    const suggestionList = document.getElementById('suggestion-list');

    // Clear previous suggestions
    suggestionList.innerHTML = '';
    console.log('Input event triggered');

    if (userInput.length >= 2) {
        // Only fetch suggestions when the user has typed at least 2 characters
        fetchSuggestions(userInput);
    } else {
        // Hide the suggestion box if the input is empty or less than 2 characters
        document.getElementById('suggestions').style.display = 'none';
    }
});

// Event listener to handle suggestion item click
document.getElementById('suggestion-list').addEventListener('click', function (event) {
    const clickedSuggestion = event.target.textContent;
    document.getElementById('caller-id').value = clickedSuggestion;
    // Hide the suggestion box after selecting a suggestion
    document.getElementById('suggestions').style.display = 'none';
});

function fetchSuggestions(userInput) {
    console.log('User input:', userInput);
    // Perform an AJAX request to fetch suggestions
    $.ajax({
    url: 'COMPONENT/FUNCTION/suggestion-endpoint.php',
    type: 'POST',
    dataType: 'json',
    data: { userInput: userInput },
    success: function (data, textStatus, xhr) {
    try {
        // Attempt to parse the JSON response
        const parsedData = JSON.parse(xhr.responseText);
        console.log('Parsed Data:', parsedData);

        // Check if the response is valid JSON
        if (parsedData && Array.isArray(parsedData.suggestions)) {
            // Handle parsedData here
            console.log('Suggestions:', parsedData.suggestions);
            const suggestionList = document.getElementById('suggestion-list');
            const suggestions = parsedData.suggestions;

            if (suggestions.length > 0) {
                suggestions.forEach(function (suggestion) {
                    const listItem = document.createElement('li');
                    listItem.textContent = suggestion;
                    suggestionList.appendChild(listItem);
                });

                document.getElementById('suggestions').style.display = 'block';
            } else {
                document.getElementById('suggestions').style.display = 'none';
            }
                } else {
                    // Handle the case where the response is not in the expected format
                    console.error('Received invalid JSON response:', xhr.responseText);
                    // Show an appropriate message to the user or handle the error
                }
            } catch (e) {
                console.error('JSON Parsing Error:', e);
                // Handle the parsing error or show an appropriate message to the user
            }
        },

        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            console.log('Response Text:', xhr.responseText);
            // Handle the error or show an appropriate message to the user
        }
    });
}

    $(document).ready(function() {
        display_events();
    })

    function display_events() {
        console.log("display_events function called");
        var events = new Array();
        var calendar = $('#calendar').fullCalendar({
            defaultView: 'customWeek',
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
            views: {
                customWeek: {
                    type: 'basicWeek',
                    duration: { weeks: 1 }, // Show one week at a time
                    buttonText: '1 Week', // Optional button text
                    slotDuration: { days: 1 }, // Hide time slots (one slot per day)
                    slotLabelFormat: ['ddd'], // Display only day names (e.g., Mon, Tue, etc.)
                },
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
                rightContent += "<img src='COMPONENT/img/delete.png' class='delete-icon' data-event-id='" + event.event_id + "' alt='Delete' height='24px' width='24px' />";
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
            url: 'COMPONENT/FUNCTION/display_event.php',
            dataType: 'json',
            success: function(response) {
                var result = response.data;
                $.each(result, function(i, item) {
                    console.log("Department: " + result[i].department);
                    // Check if the event's department matches the user's department or is set to "all"
                    if (result[i].department === '<?php echo $userDepartment; ?>' || result[i].department === 'ALL') {
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
            url: "COMPONENT/FUNCTION/save_event.php",
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
            url: 'COMPONENT/FUNCTION/update_event.php',
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
                    url: 'COMPONENT/FUNCTION/delete_event.php',
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

    <?php include "COMPONENT/footer.php" ?>
</html>
