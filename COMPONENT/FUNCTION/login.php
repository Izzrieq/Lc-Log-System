<?php
session_start();

 include "../DB/config.php"; 
// Get user input
$username = $_POST['username'];
$password = $_POST['password'];

// Perform database query
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result === false) {
    echo "Query error: " . $conn->error;
    exit;
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;

    if ($row['type'] == 'admin') {
        header("Location: ../../home.php");
    } else {
        header("Location: ../USERS/home.php");
    }
} else {
    echo "<script>alert('Invalid login credentials.'); window.location.href = '../../index.php';</script>";
}

?>
