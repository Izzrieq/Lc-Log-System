<?php
include "COMPONENT/header.php";

 $branch_id = $_GET['branch_id'];
 $sql = "delete from branch AND branchdetails where branch_id= '$branch_id'";
 $result = mysqli_query($conn, $sql);
 if ($result)
     echo "<script>alert('Deleted')</script>";
else 
   echo "<script>alert('Unsuccessful,Please Try Again Later')</script>";
echo "<script>window.location='tlcp-data.php'</script>";
?>