<?php
    include("../DB/config.php");
    date_default_timezone_set("Asia/Kuala_Lumpur");
    if(isset($_POST['cname'])) {    
    $id = (isset($_POST['id']) ? $_POST['id'] : '');
    $date = date("Y-m-d H:i:s");  
    $cname = $_POST['cname'];
    $cnohp = $_POST['cnohp'];
    $caller = $_POST['caller'];
    $channel = $_POST['channel'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $lcid = $_POST['lcid'];
	$principal = $_POST['principal'];
    $ownernohp = $_POST['ownernohp'];
    $action = $_POST['action'];

    
    $sql = "INSERT INTO complaintbliss (id, date, cname, cnohp, caller, channel, category, type, details, lcid, principal, ownernohp, action)
    VALUES ('$id', '$date', '$cname', '$cnohp', '$caller', '$channel', '$category', '$type', '$details', '$lcid', '$principal', '$ownernohp', '$action')";
    $result = mysqli_query($conn, $sql); 
    if ($result) {
        echo "<script>alert('Add Complaint Success')</script>";
        // Redirect to bliss-addcomplaint.php
        header("Location: ../../bliss-addcomplaint.php");
        exit; // Ensure the script stops executing
    } else {
        echo "<script>alert('Add Complaint Not Success')</script>";
    }
    
}
