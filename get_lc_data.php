<?php
include("COMPONENT/DB/config.php");

if(isset($_GET["code"])){
    $code = $_GET["code"];
    
    // Step 1: Convert branch code to branch ID
    // Construct your SQL query to retrieve the branch ID based on the provided code
    $branchIdQuery = "SELECT branch_id FROM branch WHERE code = '$code'";
    
    // Execute the query
    $branchIdResult = mysqli_query($conn, $branchIdQuery);
    
    if ($branchIdResult) {
        // Check if a row was returned
        if (mysqli_num_rows($branchIdResult) > 0) {
            // Fetch the branch ID from the result
            $branchIdRow = mysqli_fetch_assoc($branchIdResult);
            $branchId = $branchIdRow['branch_id'];
            
            // Step 2: Fetch data from user_teacher table for the same branch ID
            // Construct your SQL query to retrieve data from user_teacher based on branch ID
            $userDataQuery = "SELECT first_name, mobile_no FROM user_teacher WHERE branch_id = $branchId";
            
            // Execute the query
            $userDataResult = mysqli_query($conn, $userDataQuery);
            
            if ($userDataResult) {
                // Fetch data and build response array
                $response = array();
                while ($row = mysqli_fetch_assoc($userDataResult)) {
                    $response['ownerNames'][] = $row['first_name'];
                    $response['ownerNohp'][] = $row['mobile_no'];
                }
                
                // Close the result set
                mysqli_free_result($userDataResult);
                
                // Send the response as JSON
                echo json_encode($response);
            } else {
                // Handle database error for user_teacher query
                echo "Database query for user_teacher failed: " . mysqli_error($conn);
            }
        } else {
            // No branch found with the provided code
            echo "Branch not found for the given code: $code";
        }
        
        // Close the result set for branch ID query
        mysqli_free_result($branchIdResult);
    } else {
        // Handle database error for branch ID query
        echo "Database query for branch ID failed: " . mysqli_error($conn);
    }
} else {
    echo "Branch code not provided.";
}

mysqli_close($conn);
?>
