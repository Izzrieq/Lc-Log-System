<?php include "DB/config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

.navbar {
    display: flex;
    justify-content: space-between;
    background-color: white;
    padding: 10px;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
    color: black;
}
.navbar-left{
    margin-left: 5%;
}

.navbar-left ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navbar-left li {
    margin-right: 20px;
}

.navbar-left a {
    color: black;
    text-decoration: none;
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
.user-icon img {
    width: 40px; /* Set the desired width */
    height: 40px; /* Set the desired height */
}


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

</style>
<body>
<header class="d-flex justify-content-between bg-white ">
        <div class="w-25 p-0 h-75 d-inline-block">
            <a href="header.php">
            <img  class="w-100 m-0 h-100 d-inline-block" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png" alt="logo">
            </a>
        </div>
        <div class="p-0 ">
            <h1 class="mt-3 m-3 h1 text-primary">BLISS CUSTOMER E-LOG</h1>
        </div>
</header>
<nav class="navbar">
        <div class="navbar-left font-bold">
            <ul>
                <li><a href="home.php" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-2">HOME</a></li>
                <li><a href="#" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-2">ABOUT</a></li>
                <li><a href="#" class="hover:bg-gray-50 hover:text-blue-500 py-3 px-2">SERVICES</a></li>
            </ul>
        </div>
        <div class="navbar-right">
            <button class="user-icon">
                <img src="COMPONENT/img/user-icon.png" alt="User Icon">
            </button>
            <div class="user-options">
                <ul>
                    <li><a href="COMPONENT/dashmin">Dashmin</a></li>
                    <li><a href="COMPONENT/FUNCTION/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
