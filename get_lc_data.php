<?php
include("COMPONENT/DB/config.php");

if(isset($_GET["lcid"])){
    $lcid = $_GET["lcid"];
    
    // Construct your SQL query
    $sql = "SELECT ownername, ownernohp FROM lcdetails WHERE lcid = '$lcid'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Fetch data and build response array
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $response['ownerNames'][] = $row['ownername'];
            $response['ownerNohp'][] = $row['ownernohp'];
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
