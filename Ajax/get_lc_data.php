<?php
include("../COMPONENT/DB/config.php");

if(isset($_GET["code"])){
    $code = $_GET["code"];
    error_log("Received code parameter: " . $code);
    
    // Step 1: Use the provided branch code directly
    $branchCode = mysqli_real_escape_string($conn, $code);
    // Step 2: Fetch data from user_teacher table for the branch associated with the provided code
    // Construct your SQL query to retrieve data from user_teacher based on branch code
    $userDataQuery = "SELECT first_name, mobile_no FROM user_teacher WHERE branch_id = (SELECT branch_id FROM branch WHERE code = '$branchCode')";
    
    // Execute the query
    $userDataResult = mysqli_query($conn, $userDataQuery);
    
    if ($userDataResult) {
        // Fetch data and build response array
        $response = array();
        while ($row = mysqli_fetch_assoc($userDataResult)) {
            $response['principal'][] = $row['first_name'];
            $response['ownerNohp'][] = $row['mobile_no'];
        }
        
        // Close the result set
        mysqli_free_result($userDataResult);
       
        // Debugging: Log the response before sending it
        error_log(json_encode($response));
        
        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle database error for user_teacher query
        echo "Database query for user_teacher failed: " . mysqli_error($conn);
    }
} else {
    echo "Branch code not provided.";
}

mysqli_close($conn);

?>