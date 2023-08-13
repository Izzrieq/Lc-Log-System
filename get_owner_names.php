<?php
include('COMPONENT/DB/config.php');

if (isset($_GET['lcid'])) {
    $lcid = $_GET['lcid'];
    
    $sql = "SELECT DISTINCT lcowner FROM lcdetails WHERE lcid = '$lcid'";
    $result = mysqli_query($conn, $sql);
    
    $options = "";
    while ($row = mysqli_fetch_array($result)) {
        $options .= "<option value='".$row['lcowner']."'>".$row['lcowner']."</option>";
    }
    
    echo $options;
}
?>
