<?php
// Include your database configuration
include "../DB/config.php";

// Get the event details from the POST data
$title = $_POST['todo'];
$date = $_POST['date'];
$email = $_POST['email'];

// Insert the event into the database
$insert_query = "INSERT INTO workstation (email, todo, date) VALUES ('$email', '$todo', '$date')";
if (mysqli_query($conn, $insert_query)) {
    $response = array(
        'success' => true,
        'message' => 'Event saved successfully.'
    );
} else {
    $response = array(
        'success' => false,
        'message' => 'Error saving event: ' . mysqli_error($conn)
    );
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
