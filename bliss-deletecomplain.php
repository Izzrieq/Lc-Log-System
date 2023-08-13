<?php
include "COMPONENT/header.php";
 $id = $_GET['id'];
 $sql = "delete from complaintbliss where id= '$id'";
 $result = mysqli_query($conn, $sql);
 if ($result)
     echo "<script>alert('Deleted')</script>";
else 
   echo "<script>alert('Unsuccessful,Please Try Again Later')</script>";
echo "<script>window.location='bliss-operator.php'</script>";
?>