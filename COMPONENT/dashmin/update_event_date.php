<?php
var_dump($_POST); 
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(array('status' => 'Unauthorized')); // Handle unauthorized access
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../DB/config.php";

    // Get the event ID and new start date from the POST data
    $eventId = $_POST['event_id'];

    // Remove the time zone offset (Z) and convert to the desired format
    $newStartDate = date('Y-m-d H:i:s', strtotime($_POST['start_date']));

    // Validate and sanitize input as needed

    // Update the event in the database
    $query = "UPDATE events SET start_date = ? WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $newStartDate, $eventId);

    // Debugging statements
    error_log('Event ID: ' . $eventId);
    error_log('New Start Date: ' . $newStartDate);
    error_log('SQL Query: ' . $query . ' with parameters: ' . $newStartDate . ', ' . $eventId);

    if ($stmt->execute()) {
        echo json_encode(array('status' => 'Success'));
    } else {
        echo json_encode(array('status' => 'Error', 'message' => $stmt->error));
    }
} else {
    echo json_encode(array('status' => 'Invalid request')); // Handle invalid request method
}
?>
