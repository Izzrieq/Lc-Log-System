<?php 
session_start();
include "COMPONENT/DB/config.php"; 
include "COMPONENT/header.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
   echo "<script>alert('You must log in as an admin first.'); window.location.href = 'index.php';</script>";
   exit;
}

   $img = $_SESSION['img'];
   $type = $_SESSION['type'];

// Fetch departments for the dropdown
$departments_query = "SELECT DISTINCT department FROM users";
$departments_result = mysqli_query($conn, $departments_query);    

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
               echo "<script>alert('Invalid User Selected.'); window.location.href = 'task.php';</script>";
           }
       } else {
           echo "<script>alert('You can only assign tasks to users within the same department.'); window.location.href = 'task.php';</script>";
       }
   } else {
       echo "<script>alert('You cannot assign a task to yourself.'); window.location.href = 'task.php';</script>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Task Manager</title>
   <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>

   @media (max-width:425px) {
      .border-2 {
         margin-bottom: 1rem;
      }
      .mt-4 {
         font-size: 1rem;
      }
      #btn-viewtask {
         padding: 4px 1px;
      }
   }
</style>

<body>
   <div class="flex justify-between mt-2">
      <button class="rounded-md bg-blue-700 text-white text-sm px-3 py-2 ml-2" type="back" onclick="history.back()">BACK
         <i class="fa fa-undo" aria-hidden="true"></i>
      </button> 
         <h2 class="font-bold text-2xl text-center mt-1">ASSIGN TASK</h2>
         <div></div>
   </div>
<!-- Content Start -->
<div class="p-2">
    <div class="border border-2 border-slate-200 shadow bg-slate-100 rounded-lg p-4">
        <div class="flex justify-between mb-0">
            <a href="viewtask.php">
                <button
                    id="btn-viewtask"
                    class="border border-black text-black bg-white rounded-lg text-sm font-semibold px-5 py-2.5 hover:scale-105">View Task
                </button>
            </a>
        </div>
        <div class="container">
            <div class="text-center font-semibold rounded p-4">
                <div class="flex justify"></div>
                <form method="post">
                    <div class="mb-3">
                        <label for="assigned_to" class="font-semibold">Assign To</label>
                        <select
                            class="w-full border-0 px-3 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 mt-2"
                            name="assigned_to"
                            id="assigned_to"
                            required="required">
                            <option value="" selected="selected" disabled="disabled">Select a user</option>
                            <?php while ($department_row = mysqli_fetch_assoc($departments_result)) { ?>
                            <optgroup label="<?php echo $department_row['department']; ?>">
                                <?php
                            $users_query = "SELECT fullname FROM users WHERE department = '{$department_row['department']}'";
                            $users_result = mysqli_query($conn, $users_query);
                            while ($user_row = mysqli_fetch_assoc($users_result)) {
                                echo "<option value='{$user_row['fullname']}'>{$user_row['fullname']}</option>";
                            }
                            ?>
                            </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="task_description" class="form-label">Task Description</label>
                        <textarea
                            class="w-full border-0 px-3 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 mt-2"
                            name="task_description"
                            rows="3"
                            required="required"></textarea>
                    </div>
                    <button
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script>

   const assignedToSelect = document.getElementById('assigned_to');

   // Get the input element for the department
   const departmentInput = document.getElementById('department');

   // Add an event listener to the select element
   assignedToSelect.addEventListener('change', function () {
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
               " has been marked as completed by user <?php echo $_SESSION['name']; ?>";
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
      xhr.send('name=' + encodeURIComponent(name) + '&message=' + encodeURIComponent(message));
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
         xhr.open('POST', 'clear_notifications_read.php',
         true); // Change the URL to the script that clears notifications
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

</html>