<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

include "../DB/config.php"; 
// Debug: Output received data
echo "Received eventID: " . $_POST["eventID"] . "<br>";
echo "Received newStartDate: " . $_POST["newStartDate"] . "<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST["eventID"];
    $newStartDate = $_POST["newStartDate"];
    
    // Perform the database update
    $queryUpdate = "UPDATE events SET start_date = ? WHERE event_id = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);

    if ($stmtUpdate) {
        $stmtUpdate->bind_param('ss', $newStartDate, $eventID);
        
        if ($stmtUpdate->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmtUpdate->error;
        }
        

        $stmtUpdate->close();
    } else {
        echo "Error: Unable to prepare the statement.";
    }
}
?>
