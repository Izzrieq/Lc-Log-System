<?php
session_start();
include "COMPONENT/DB/config.php"; 

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = '../../index.php';</script>";
    exit;
}

// Check if a file was uploaded
if (isset($_FILES['fileToUpload'])) {
    $taskId = mysqli_real_escape_string($conn, $_POST['taskId']); // Sanitize user input
    $targetDir = "uploadFile/"; // Change this to the directory where you want to store uploaded files
    $targetFile = $targetDir . basename($_FILES['fileToUpload']['name']);
    
    // Check if the file is valid
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
        // Insert the file information into the database
        $insertFileQuery = "INSERT INTO task_files (task_id, file_name) VALUES ('$taskId', '$targetFile')";
        mysqli_query($conn, $insertFileQuery);

        // Redirect back to the task page
        echo "<script>alert('Make sure you send the evidence related with your task.')</script>";
    echo "<script>window.location='viewtask.php'</script>";
        exit;
    } else {
        echo "Error uploading file.";
    }
}
?>
