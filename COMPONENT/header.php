<?php
include "DB/config.php"; // Include your database connection
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

// Assuming you have a session or some way to identify the user, e.g., $_SESSION['user_id']
$user_id = $_SESSION['user_id']; // Replace with the actual way you identify the user
$img = $_SESSION['img'];

// Query to retrieve the user's image from the "users" table based on user_id
$sql = "SELECT img FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $user_id); // 's' represents a string (assuming user_id is a string)
    $stmt->execute();

    // Check if the execution was successful
    if ($stmt->errno) {
        die("Execution failed: " . $stmt->error);
    }

    $stmt->bind_result($userImage);
    $stmt->fetch();

    $stmt->close();
} else {
    // Handle the case where prepare fails
    die("Prepare failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    const userIcon = document.querySelector(".user-icon");
    const userOptions = document.querySelector(".user-options");

    userIcon.addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent the click event from bubbling up to the document

        if (userOptions.style.display === "block") {
            userOptions.style.display = "none";
        } else {
            userOptions.style.display = "block";
        }
    });

    // Close user options if user clicks anywhere outside the user icon and options
    document.addEventListener("click", function(event) {
        if (!userIcon.contains(event.target) && !userOptions.contains(event.target)) {
            userOptions.style.display = "none";
        }
    });
});

</script>
<style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}
.navbar-right{
    margin-right: 25px ;
}
.rounded-image {
        border-radius: 50%; /* This creates a circular border */
        width: 75px; /* Adjust the width and height as needed */
        height: 75px;
    }

.user-icon {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}
.user-options {
    display: none;
    position: absolute;
    top: 80px;
    margin-right: 15px;
    right: 0;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1;
}

.user-options ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.user-options li {
    padding: 8px 20px;
    border-bottom: 1px solid #ccc;
}
.user-options li:hover {
    background: #ADD8E6;
}

.user-options {
    color: #333;
    text-decoration: none;
}

.user-icon:hover .user-options {
    display: block;
}
@media (max-width: 576px) {
            .logo {
                width: 150px;
            }
            .mt-3{
                display: none;
            }
            a{
                font-size: 0.90rem;
            }
            .rounded-image{
                width: 60px;
                height: 60px;
            }
            .navbar-left{
                margin-top: 20px;
            }
            .navbar-right{
                margin-top: 10px;
                margin-right: 30px;
            }
            .user-options{
                top: 70px;
            }
}

</style>
<body>
    <!-- <?php
    echo "<script>
    document.getElementById('user-image').src = 'COMPONENT/img/default-user-icon.png';
  </script>";
    ?> -->
<header class="d-flex justify-content-between bg-white p-3">
        <div class="logo" style="width: 350px; height: auto; padding: 0px;">
            <a href="home.php">
            <img  class="w-100 h-100" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png" alt="logo">
            </a>
        </div>
        <div class="mt-3 p-0">
            <h1 class="mt-3 m-3 text-primary" style="font-size: 2rem; ">BLISS CUSTOMER E-LOG</h1>
        </div>
</header>
<nav class="navbar w-full d-flex justify-content-between shadow bg-white">
        <div class="navbar-left font-bold">
            <ul class="d-flex">
                <li><a href="home.php" class="hover:bg-gray-50 text-black py-3 px-3 text-decoration-none">HOME</a></li>
                <li><a href="COMPONENT/FUNCTION/construction.php" class="hover:bg-red-100 text-black py-3 px-3 text-decoration-none">ABOUT</a></li>
                <li><a href="COMPONENT/FUNCTION/print-report.php" class="hover:bg-gray-50 text-black py-3 px-3 text-decoration-none">REPORT</a></li>
            </ul>
        </div>
        <div class="navbar-right">
        <button class="user-icon" data-user-id="<?php echo $user_id; ?>">
            <img class="rounded-image" src="COMPONENT/uploads/<?php echo $img; ?>" alt="User Image" width="75" height="75">
        </button>

        <div class="user-options">
         <ul>
             <li><a href="COMPONENT/setting.php">Setting</a></li>
             <li><a href="COMPONENT/FUNCTION/logout.php">Logout</a></li>
         </ul>
    </div>
</div>
</nav>
