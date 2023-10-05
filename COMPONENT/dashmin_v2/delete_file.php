<?php
session_start();
include "../DB/config.php";

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "You must log in first.";
    exit;
}

if ($_SESSION['type'] !== 'admin') {
    echo "Only admin users can delete files.";
    exit;
}

if (isset($_POST['file_id'])) {
    $fileId = $_POST['file_id'];
    
    // Get file details from the database
    $file_query = "SELECT * FROM task_files WHERE id = $fileId";
    $file_result = mysqli_query($conn, $file_query);
    $file = mysqli_fetch_assoc($file_result);

    if (!$file) {
        echo "File not found.";
        exit;
    }

    // Delete the file from the server
    $filePath = "../uploads/" . $file['file_name'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete file record from the database
    $delete_query = "DELETE FROM task_files WHERE id = $fileId";
    if (mysqli_query($conn, $delete_query)) {
        echo "File deleted successfully.";
    } else {
        echo "Error deleting file: " . mysqli_error($conn);
    }
} else {
    echo "File ID not provided.";
}
?>
