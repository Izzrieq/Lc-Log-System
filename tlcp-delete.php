<?php
include "COMPONENT/header.php";

$branch_id = $_GET['branch_id'];

// Delete data from the 'branch' table
$sql1 = "DELETE FROM branch WHERE branch_id = '$branch_id'";
$result1 = mysqli_query($conn, $sql1);

// Delete data from the 'branchdetails' table
$sql2 = "DELETE FROM branchdetails WHERE branch_id = '$branch_id'";
$result2 = mysqli_query($conn, $sql2);

if ($result1 && $result2) {
    echo "<script>alert('Deleted')</script>";
    echo "<script>window.location='tlcp-data.php'</script>";
} else {
    echo "<script>alert('Unsuccessful, Please Try Again Later')</script>";
    echo "<script>window.location='tlcp-data.php'</script>";
}
?>
