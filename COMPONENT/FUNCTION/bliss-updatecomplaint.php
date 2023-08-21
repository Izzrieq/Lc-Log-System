<?php
include_once ("../DB/config.php");

if(isset($_POST['update'])) {  
    $id = $_POST['id'];
    $date = date("Y-m-d H:i:s");  
    $cname = $_POST['cname'];
    $cnohp = $_POST['cnohp'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $details = $_POST['details'];
	$lcowner = $_POST['lcowner'];
    $ownernohp = $_POST['ownernohp'];

    $result = mysqli_query($conn, "UPDATE complaintbliss SET id='$id',date='$date',cname='$cname',cnohp='$cnohp',category='$category',type='$type',
    details='$details',lcowner='$lcowner',ownernohp='$ownernohp' 
    WHERE id='$id'");
    if ($result){
        echo "<script>alert('SUCCESFULL UPDATE')</script>";
        echo "<script>window.location='../../bliss-operator.php'</script>";
    }else{ 
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='../../bliss-updatecomplaint-form.php'</script>";
    }
}
?>