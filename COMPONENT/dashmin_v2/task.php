<?php 
include "../DB/config.php"; 
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['type'] !== 'admin') {
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

   <!-- Content Start -->
   <div class="p-4 sm:ml-64">
      <div class="border-dashes border-2 border-slate-200 bg-slate-100 rounded-lg p-4 mt-14">
         <div class="container-fluid px-4">
            <div class="bg-light text-center font-semibold rounded p-4">
               <div class="flex justify-start mb-12">
                  <h6 class="mb-0 text-xl">Assign Task</h6>
               </div>
               <form method="post">
                  <div class="mb-3">
                     <label for="assigned_to" class="font-semibold">Assign To</label>
                     <select
                        class="w-full border-0 px-3 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 mt-2"
                        name="assigned_to" id="assigned_to" required>
                        <option value="" selected disabled>Select a user</option>
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
                        name="task_description" rows="3" required></textarea>
                  </div>
                  <button type="submit"
                     class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Assign</button>
               </form>
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