<?php 
include "../DB/config.php"; 
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['usertype'] !== 'admin') {
    echo "<script>alert('You must log in as an admin first.'); window.location.href = 'index.php';</script>";
    exit;
}

// Fetch departments for the dropdown
$departments_query = "SELECT DISTINCT department FROM users";
$departments_result = mysqli_query($conn, $departments_query);

// Handle form submission
// Handle form submission
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
                $insert_query = "INSERT INTO tasks (assigned_to, task_description, assigned_by, date_assigned) 
                                 VALUES ('$assigned_to', '$task_description', '$assigned_by', '$date_assigned_utc')";
                
                if (mysqli_query($conn, $insert_query)) {
                    echo "<script>alert('Task assigned successfully.'); window.location.href = 'task.php';</script>";
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
    <!-- ... (your head content) ... -->
</head>
<body>
    <!-- ... (your header and navigation) ... -->

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Assign Task</h6>
            </div>
            <form method="post">
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select class="form-select" name="assigned_to" required>
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
                <button type="submit" class="btn btn-primary">Assign Task</button>
            </form>
        </div>
    </div>

    <!-- ... (your footer and scripts) ... -->
</body>
</html>
