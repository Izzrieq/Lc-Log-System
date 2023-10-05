<?php
session_start();
include "../DB/config.php"; // Include your database connection

// Get notification details from AJAX request
$recipientname = $_POST['name'];
$notificationMessage = $_POST['message'];

// Insert the notification into the database
$insert_notification_query = "INSERT INTO notifications (name, message, status) VALUES ('$recipientname', '$notificationMessage', 'unread')";
if (mysqli_query($conn, $insert_notification_query)) {
    echo "success"; // Send a success response
} else {
    echo "error"; // Send an error response
}
?>