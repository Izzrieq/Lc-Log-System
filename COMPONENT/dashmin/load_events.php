<?php
include "../DB/config.php";

$events = array();

$query = "SELECT * FROM workstation"; // Replace with your table name
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $events[] = array(
        'title' => $row['todo'],
        'start' => $row['date']
    );
}

echo json_encode($events);
?>
