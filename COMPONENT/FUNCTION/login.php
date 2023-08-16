<?php
session_start();
include "../DB/config.php"; 

// Get user input
$username = $_POST['username'];
$password = $_POST['password'];

// Sanitize user input to prevent SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Perform database query
$sql = "SELECT * FROM users WHERE username = '$username'";
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
        $_SESSION['username'] = $username;
        $_SESSION['department'] = $row['department'];
        $_SESSION['type'] = $row['type'];

        if ($row['type'] == 'admin') {
            header("Location: ../../home.php"); // Redirect admin to this page
        } else if ($row['type'] == 'user') {
            header("Location: ../USERS/home.php"); // Redirect non-admin users to this page
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
