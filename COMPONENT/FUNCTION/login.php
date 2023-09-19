<?php
session_start();
include "../DB/config.php"; 

// Get user input
$user_id = $_POST['user_id'];
$password = $_POST['password'];

// Sanitize user input to prevent SQL injection
$user_id = mysqli_real_escape_string($conn, $user_id);
$password = mysqli_real_escape_string($conn, $password);

// Perform database query
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Query error: " . $conn->error;
    exit;
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Verify password
    if ($password == $row['password']) { // This is plain text comparison
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['department'] = $row['department'];
        $_SESSION['type'] = $row['type'];

        if ($row['type'] == 'admin') {
            header("Location: ../../home.php"); // Redirect admin to this page
        } else if ($row['type'] == 'user') {
            header("Location: ../../home.php"); // Redirect non-admin users to this page
        } else {
            echo "<script>alert('Invalid user type.'); window.location.href = '../../index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid login credentials.'); window.location.href = '../../index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid login credentials.'); window.location.href = '../../index.php';</script>";
}
?>
