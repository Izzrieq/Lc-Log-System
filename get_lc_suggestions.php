<?php
include("COMPONENT/DB/config.php"); // Include your database configuration

if (isset($_GET['term'])) {
    $term = $_GET['term']; // User input from the autocomplete widget
    
    // Query the database for LC ID suggestions
    $sql = "SELECT DISTINCT lcid FROM lcdetails WHERE lcid LIKE '%$term%'";
    $result = mysqli_query($conn, $sql);
    
    // Build an array of LC ID suggestions
    $suggestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row['lcid'];
    }
    
    // Return the suggestions as a JSON array
    echo json_encode($suggestions);
}
?>



