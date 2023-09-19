<?php
// Start a session if not already started
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "Error: You must log in first.";
    exit;
}

// Include your database configuration
include "../DB/config.php"; 

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request
    $eventTitle = $_POST['title'];
    $newStartDate = $_POST['start_date'];

    // Prepare the SQL query
    $queryInsert = "INSERT INTO events (title, start_date) VALUES (?, ?)";
    $stmt = $conn->prepare($queryInsert);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param('ss', $eventTitle, $newStartDate);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Success"; // Event added successfully
        } else {
            echo "Error: " . $stmt->error; // Display any SQL errors
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Unable to prepare the statement.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
