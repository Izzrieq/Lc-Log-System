<?php
    include("../DB/config.php");
    date_default_timezone_set("Asia/Kuala_Lumpur");
    if(isset($_POST['cname'])) {    
    $id = (isset($_POST['id']) ? $_POST['id'] : '');
    $date = date("Y-m-d H:i:s");  
    $cname = $_POST['cname'];
    $cnohp = $_POST['cnohp'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $lcid = $_POST['lcid'];
	$principal = $_POST['lcowner'];
    $ownernohp = $_POST['ownernohp'];
    $action = $_POST['action'];
    
    $sql = "INSERT INTO complaintbliss (id, date, cname, cnohp, category, type, details, lcid, lcowner, ownernohp, action)
    VALUES ('$id', '$date', '$cname', '$cnohp', '$category', '$type', '$details', '$lcid', '$principal', '$ownernohp', '$action')";
    $result = mysqli_query($conn, $sql); 
    if ($result)
        echo "<script>alert('Add Complaint Success')</script>";
    else 
        echo "<script>alert('Add Complaint Not Success')</script>";
        echo "<script>window.location='../../bliss-operator.php'</script>";
}
