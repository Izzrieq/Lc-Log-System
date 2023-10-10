<?php
include("../COMPONENT/DB/config.php");

if(isset($_GET["first_name"])){
    $first_name = $_GET["first_name"];
    
    // Construct your SQL query
    $sql = "SELECT mobile_no FROM emergency_contact WHERE first_name = '$first_name'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Fetch data and build response array
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $response['customerNohp'][] = $row['mobile_no'];
        }
        
        // Close the result set
        mysqli_free_result($result);
        
        // Send the response as JSON
        echo json_encode($response);
    } else {
        // Handle database error
        echo "Database query failed: " . mysqli_error($conn);
    }
} else {
    echo "LCID not provided.";
}

mysqli_close($conn);
?>
