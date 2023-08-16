<?php
session_start();
include "../DB/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    $taskId = $_POST['taskId'];
    
    // Handle file upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Check if file is selected
    if (!empty($_FILES["fileToUpload"]["name"])) {
        // Allow certain file formats
        $allowedTypes = array('pdf', 'doc', 'docx', 'txt');
        if (in_array($fileType, $allowedTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
                // Update task record with file information
                $updateQuery = "UPDATE tasks SET file_name = '$fileName', file_path = '$targetFilePath' WHERE id = '$taskId'";
                if (mysqli_query($conn, $updateQuery)) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Error updating task record: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowedTypes);
        }
    } else {
        echo "Please select a file to upload.";
    }
}
?>
