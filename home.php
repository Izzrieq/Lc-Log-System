<?php 
    include "COMPONENT/DB/config.php"; 
    include "COMPONENT/header.php";

    //wajib ada setiap page
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal Little Caliphs</title>
    <link rel="icon" type="image/png" href="COMPONENT/img/logolc.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        /* Additional CSS if needed */
    </style>
</head>

<<<<<<< HEAD
<body class="bg-neutral-50">
=======
<body class="bg-neutral-50 mb-5">
>>>>>>> ce06da19db031a2aa52b755c1525b698e82828c0

    <h2 class="px-6 mb-0 mt-2 text-primary text-2xl">WELCOME, <?php echo strtoupper($_SESSION['username']); ?>!<br>
        <h5 class="px-7 text-secondary"><?php echo ($_SESSION['type'])?></h5>
    </h2>

    <h1 class="text-center text-black text-2xl">Our Services</h1>

    <div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">KINDY DETAILS</h5>
                    <p class="card-text">All kindergarten information.</p>
                    <a href="tlcp-data.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">COMPLAINT</h5>
                    <p class="card-text">Getting issue complaint.</p>
                    <a href="bliss-operator.php" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold text-base">INFO</h5>
                    <p class="card-text">Masih tiada idea.</p>
                    <a href="#" class="btn btn-primary mt-2">Go Somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
    <?php include "COMPONENT/footer.php" ?>
</html>
