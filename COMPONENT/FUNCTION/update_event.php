<?php
include("../DB/config.php");

// Initialize the response array
$response = array();

try {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the event_id and new start date from the POST data
        $event_id = $_POST["event_id"];
        $new_start_date = $_POST["event_start_date"];
        
        // Prepare and execute an SQL update query
        $sql = "UPDATE events SET event_start_date = ? WHERE event_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the query
            $stmt->bind_param("si", $new_start_date, $event_id);
            if ($stmt->execute()) {
                $response["status"] = true;
                $response["msg"] = "Event date updated successfully.";
            } else {
                $response["status"] = false;
                $response["msg"] = "Error updating event date: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $response["status"] = false;
            $response["msg"] = "Error preparing SQL statement: " . $mysqli->error;
        }
    } else {
        // If the request method is not POST, return an error response
        $response["status"] = false;
        $response["msg"] = "Invalid request method.";
    }
} catch (Exception $e) {
    $response["status"] = false;
    $response["msg"] = "Exception: " . $e->getMessage();
}

// Close the database connection
$conn->close();

// Send JSON response
header("Content-Type: application/json");
echo json_encode($response);
?>
