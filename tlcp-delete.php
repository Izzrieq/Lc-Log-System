<?php
include "COMPONENT/header.php";

 $id = $_GET['id'];
 $sql = "delete from lcdetails where id= '$id'";
 $result = mysqli_query($conn, $sql);
 if ($result)
     echo "<script>alert('Deleted')</script>";
else 
   echo "<script>alert('Unsuccessful,Please Try Again Later')</script>";
echo "<script>window.location='tlcp-data.php'</script>";
?>