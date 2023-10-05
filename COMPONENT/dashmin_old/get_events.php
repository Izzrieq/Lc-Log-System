<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

include "../DB/config.php";
$department = $_SESSION['department'];

// Fetch events from the database
$query = "SELECT event_id, title, start_date, end_date, department FROM events";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to store the events
$events = array();

// Fetch events and add them to the array
while ($row = $result->fetch_assoc()) {
    $event = array(
        'id' => $row['event_id'], // Include the event ID
        'title' => $row['title'], // Include the event title
        'start' => $row['start_date'],
        'end' => $row['end_date'],
        'departmentTitle' => $row['department']
    );
    $events[] = $event;
}

// Return the events as JSON
header('Content-Type: application/json');
echo json_encode($events);

?>