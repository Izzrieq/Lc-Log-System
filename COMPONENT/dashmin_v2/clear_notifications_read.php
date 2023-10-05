<?php
session_start();
include "../DB/config.php";

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Handle authentication error
    echo json_encode(array('status' => 'error', 'message' => 'Authentication error'));
    exit;
}

$user_id = $_SESSION['user_id'];

// Clear read notifications for the user
$clear_read_notifications_query = "DELETE FROM notifications WHERE user_id = '$user_id' AND status = 'read'";
$result = mysqli_query($conn, $clear_read_notifications_query);

if ($result) {
    echo json_encode(array('status' => 'success', 'message' => 'Notifications cleared successfully'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error clearing notifications'));
}
?>
