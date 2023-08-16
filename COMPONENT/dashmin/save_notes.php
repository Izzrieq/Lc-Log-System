<?php
session_start();
include "../DB/config.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST["date"];
    $notes = $_POST["notes"];
    $userId = $_SESSION["user_id"]; // Replace with actual user ID
    $userEmail = $_SESSION["user_email"]; // Replace with actual user email

    $insertQuery = "INSERT INTO workstation (user_id, user_email, date, notes) VALUES ('$userId', '$userEmail', '$date', '$notes')";
    
    if (mysqli_query($conn, $insertQuery)) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false, "message" => "Error: " . mysqli_error($conn));
    }

    echo json_encode($response);
}
?>
