<?php include "COMPONENT/DB/config.php" ?> 
<?php include "COMPONENT/header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="COMPONENT/STYLE/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    
    <h1 class="text-center text-white mt-3">Our Services</h1>
    <div class="d-flex justify-content-center">
        
        <div class="m-3">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">TLCP</h5>
                    <p class="card-text">The Little Caliph Playschool.</p>
                    <a href="tlcp-data.php" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="m-3">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Complain</h5>
                    <p class="card-text">Getting issue complain.</p>
                    <a href="bliss-operator.php" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="m-3">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">INFO</h5>
                    <p class="card-text">Masih tiada idea.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include "COMPONENT/footer.php" ?>