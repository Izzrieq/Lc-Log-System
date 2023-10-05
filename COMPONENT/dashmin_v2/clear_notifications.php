<?php
include "../DB/config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        http_response_code(403); // Forbidden
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Perform query to update notification status to 'read'
    $update_notification_query = "UPDATE notifications SET status = 'read' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $update_notification_query)) {
        // Get the count of unread notifications
        $unread_count_query = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = '$user_id' AND status = 'unread'";
        $unread_count_result = mysqli_query($conn, $unread_count_query);
        $unread_count_row = mysqli_fetch_assoc($unread_count_result);
        $unread_count = $unread_count_row['unread_count'];

        // Respond with the updated unread count
        echo json_encode(array('unread_count' => $unread_count));
    } else {
        http_response_code(500); // Internal Server Error
        echo "Error updating notifications: " . mysqli_error($conn);
    }
} else {
    http_response_code(405); // Method Not Allowed
}
?>
