<?php
include_once ("DB/config.php");

if(isset($_POST['update'])) {  
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $department = $_POST['department'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $nohp= $_POST['nohp'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $marriage_status = $_POST['marriage_status'];


    $result = mysqli_query($conn, "UPDATE users SET user_id='$user_id',username='$username',department='$department',fullname='$fullname',email='$email',nohp='$nohp',ic='$ic',
    address='$address',marriage_status='$marriage_status' 
    WHERE user_id=$user_id");

    if ($result){
        echo "<script>alert('Now Your Profile Information SUCCESS To CHANGES.')</script>";
        echo "<script>window.location='../home.php'</script>";
    }else {
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='seeting.php'</script>";
    }
}

?>