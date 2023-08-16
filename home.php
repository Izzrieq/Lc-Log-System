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
    <!-- <link rel="stylesheet" href="COMPONENT/STYLE/style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="bg-neutral-50">

    <h2 class="px-6 py-4">WELCOME, <?php echo strtoupper ($_SESSION['username']); ?>!</h2>
    <h1 class="text-center text-black">Our Services</h1>

    <div class="d-flex justify-content-center">
        <div class="m-4">
            <div class="card" style="width: 20rem; height: 13rem;">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold">TLCP</h5>
                    <br>
                    <p class="card-text">The Little Caliph Playschool.</p>
                    <a href="tlcp-data.php" class="btn btn-primary mt-10">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="m-4">
            <div class="card" style="width: 20rem; height: 13rem;">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold">COMPLAINT</h5>
                    <br>
                    <p class="card-text">Getting issue complaint.</p>
                    <a href="bliss-operator.php" class="btn btn-primary mt-10">Go Somewhere</a>
                </div>
            </div>
        </div>
        <div class="m-4">
            <div class="card" style="width: 20rem; height: 13rem;">
                <div class="card-body shadow-md hover:shadow-lg hover:shadow-blue-400">
                    <h5 class="card-title font-bold">INFO</h5>
                    <br>
                    <p class="card-text">Masih tiada idea.</p>
                    <a href="#" class="btn btn-primary mt-10">Go Somewhere</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include "COMPONENT/footer.php" ?>