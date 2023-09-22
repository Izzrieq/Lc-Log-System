<?php
include "../COMPONENT/DB/config.php"; 

// Initialize the response array
$response = array();

try {
    // Check if the request method is POST and if the 'event_id' parameter is set
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
        // Get the event_id from the POST data
        $eventIdToDelete = $_POST['event_id'];
        
        // Prepare and execute an SQL delete query
        $sql = "DELETE FROM events WHERE event_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param("i", $eventIdToDelete);
            if ($stmt->execute()) {
                $response["status"] = true;
                $response["msg"] = "Event deleted successfully.";

                // Add a refresh flag to indicate that the page should be refreshed
                $response["refresh"] = true;
            } else {
                $response["status"] = false;
                $response["msg"] = "Error deleting event: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $response["status"] = false;
            $response["msg"] = "Error preparing SQL statement: " . $conn->error;
        }
    } else {
        // If the request method is not POST or 'event_id' is not set, return an error response
        $response["status"] = false;
        $response["msg"] = "Invalid request. Please provide a valid 'event_id'.";
    }
} catch (Exception $e) {
    // Handle exceptions and log them
    error_log("Exception: " . $e->getMessage());
    $response["status"] = false;
    $response["msg"] = "An error occurred: " . $e->getMessage();
}

// Close the database connection
$conn->close();

// Send JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>
