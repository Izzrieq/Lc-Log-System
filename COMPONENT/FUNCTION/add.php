<?php
    include("../DB/config.php");
    date_default_timezone_set("Asia/Kuala_Lumpur");

    if(isset($_POST['cname'])) {    
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

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO complaintbliss (date, cname, cnohp, caller, channel, category, type, details, lcid, principal, ownernohp, action) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssssssss", $date, $cname, $cnohp, $caller, $channel, $category, $type, $details, $lcid, $principal, $ownernohp, $action);

        if ($stmt->execute()) {
            echo "<script>alert('Add Complaint Success');</script>"; 
            header("Location: ../../bliss-operator.php");
            exit; // Ensure the script stops executing
        } else {
            echo "<script>alert('Add Complaint Not Success')</script>";
        }
        $stmt->close();
        $conn->close();
    }
?>
