<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

include "../DB/config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST["eventID"];
    $newStartDate = $_POST["newStartDate"];
    
    // Perform the database update
    $queryUpdate = "UPDATE events SET start_date = ? WHERE event_id = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param('si', $newStartDate, $eventID);
    
    if ($stmtUpdate->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>