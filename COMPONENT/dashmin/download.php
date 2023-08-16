<?php
include "../DB/config.php";

if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];

    $file_query = "SELECT * FROM task_files WHERE id = $file_id";
    $file_result = mysqli_query($conn, $file_query);
    $file = mysqli_fetch_assoc($file_result);

    if ($file) {
        $file_name = $file['file_name'];
        $file_path = "../uploads/" . $file_name;

        if (file_exists($file_path)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Content-Length: ' . filesize($file_path));

            readfile($file_path);
            exit;
        }
    }
}

// Redirect back to the previous page if file not found or invalid file_id
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
