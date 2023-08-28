<?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

include "../DB/config.php"; 
$department = $_SESSION['department'];

// Fetch events based on user's department
$query = "SELECT event_id, title, start_date, end_date, start_time, department FROM events WHERE department = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $department);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    // Combine start date and start time to create the full start datetime
    $startDateTime = $row['start_date'] . ' ' . $row['start_time'];
    
    $events[] = [
        'id' => $row['event_id'], // Add the event_id property
        'title' => $row['title'] . ' (' . $row['start_time'] . ')',
        'start' => $startDateTime,
        'end' => $row['end_date'],
        'departmentTitle' => $row['department']
    ];
}

echo json_encode($events);
?>