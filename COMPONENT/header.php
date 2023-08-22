<?php include "DB/config.php" ?>
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

    userIcon.addEventListener("click", function() {
        userOptions.style.display = userOptions.style.display === "block" ? "none" : "block";
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
    margin-right: 15px ;
}

.user-icon {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}
/* .user-icon img {
    width: 40px; 
    height: 40px;
} */


.user-options {
    display: none;
    position: absolute;
    top: 50px;
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

.user-options a {
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
            .m-0{
                display: none;
            }
            a{
                font-size: 0.80rem;
            }
            .user-icon{
                width:3vh;
                height:auto;
            }
}

</style>
<body>
<header class="d-flex justify-content-between bg-white p-3">
        <div class="logo" style="width: 350px; height: auto; padding: 0px;">
            <a href="home.php">
            <img  class="w-100 h-100" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png" alt="logo">
            </a>
        </div>
        <div class="m-0 p-0">
            <h1 class="mt-3 m-3 text-primary" style="font-size: 2rem; ">BLISS CUSTOMER E-LOG</h1>
        </div>
</header>
<nav class="navbar w-1/1 d-flex justify-content-between shadow bg-white rounded">
        <div class="navbar-left font-bold">
            <ul class="d-flex">
                <li><a href="home.php" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-3 text-decoration-none">HOME</a></li>
                <li><a href="COMPONENT/FUNCTION/info.php" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-2 text-decoration-none">ABOUT</a></li>
                <li><a href="COMPONENT/FUNCTION/choose-report.php" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-2 text-decoration-none">REPORT</a></li>
            </ul>
        </div>
        <div class="navbar-right">
            <button class="user-icon">
                <img src="COMPONENT/img/user-icon.png" alt="User Icon" style="width: 40px; height: auto;">
            </button>
            <div class="user-options">
                <ul>
                    <li><a href="COMPONENT/dashmin">Dashmin</a></li>
                    <li><a href="COMPONENT/FUNCTION/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
