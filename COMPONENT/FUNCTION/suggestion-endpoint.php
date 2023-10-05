<?php
include_once "../DB/config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['userInput'])) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

// Sanitize and get the user input
$userInput = trim($_POST['userInput']);

// Define an array to store suggestions
$suggestions = [];

function logQuery($stmt) {
    $bindings = $stmt->debugDumpParams();

    if (is_array($bindings) && count($bindings) >= 2) {
        $sql = $bindings[0];
        $params = $bindings[1];

        // Log the SQL statement and parameters
        error_log("SQL Query: $sql");
        error_log("Bound Parameters: " . json_encode($params));
    } else {
        // Log a message indicating that debugDumpParams() did not return the expected data
        error_log("Failed to retrieve SQL query and parameters");
    }
}

// Perform database queries to fetch suggestions
try {
    $conn = new PDO("mysql:host=localhost;dbname=blissdb", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query the 'complaintbliss' table for suggestions
    $complaintblissQuery = $conn->prepare("SELECT DISTINCT cnohp FROM complaintbliss WHERE cnohp LIKE CONCAT('%', :userInput, '%') LIMIT 5");
    $complaintblissQuery->bindParam(':userInput', $userInput, PDO::PARAM_STR);
    $complaintblissQuery->execute();
    // Log the query
    logQuery($complaintblissQuery);

    // Fetch results
    $complaintblissResults = $complaintblissQuery->fetchAll(PDO::FETCH_COLUMN);

    // Query the 'emergency_contact' table for suggestions
    $emergencyContactQuery = $conn->prepare("SELECT DISTINCT mobile_no FROM emergency_contact WHERE mobile_no LIKE CONCAT('%', :userInput, '%') LIMIT 5");
    $emergencyContactQuery->bindParam(':userInput', $userInput, PDO::PARAM_STR);
    $emergencyContactQuery->execute();
    // Log the query
    logQuery($emergencyContactQuery);

    $emergencyContactResults = $emergencyContactQuery->fetchAll(PDO::FETCH_COLUMN);

    // Query the 'spouse' table for suggestions
    $spouseQuery = $conn->prepare("SELECT DISTINCT mobile_no FROM spouse WHERE mobile_no LIKE CONCAT('%', :userInput, '%') LIMIT 5");
    $spouseQuery->bindParam(':userInput', $userInput, PDO::PARAM_STR);
    $spouseQuery->execute();
    // Log the query
    logQuery($spouseQuery);

    $spouseResults = $spouseQuery->fetchAll(PDO::FETCH_COLUMN);

    // Combine results from all tables into a single array of suggestions
    $suggestions = array_merge($complaintblissResults, $emergencyContactResults, $spouseResults);

    // Remove duplicate suggestions
    $suggestions = array_unique($suggestions);

    // Remove hyphens from phone numbers
    $suggestions = array_map(function ($number) {
        return str_replace('-', '', $number);
    }, $suggestions);

    // Limit the number of suggestions to 5
    $suggestions = array_slice($suggestions, 0, 5);
} catch (PDOException $e) {
    // Handle database connection or query errors here
    // You can log or handle the error as needed
    error_log('Database Error: ' . $e->getMessage());
    $suggestions = ["Database Error"];
}

// Return the suggestions as JSON
header('Content-Type: application/json');
echo json_encode(['suggestions' => $suggestions]);
?>
