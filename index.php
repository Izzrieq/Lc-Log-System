<?php include "COMPONENT/header.php" ?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <link rel="stylesheet" href="COMPONENT/STYLE/style.css">
 </head>
 <body>
    <center>
    <form class="login" action="COMPONENT/FUNCTION/login.php" method="post">
     	<h2>LOGIN</h2>
        <img src="COMPONENT/img/user.png" alt="user">
        <br>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>User Name</label> <br>
     	<input type="text" name="username" ><br>

     	<label>User Password</label> <br>
     	<input type="password" name="password" ><br>
            <br>
         <button type="submit" class="btn btn-primary">Login</button>
     </form>
     </center>
 </body>
 </html>

<?php include "COMPONENT/footer.php" ?>