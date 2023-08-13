<?php
include('COMPONENT/DB/config.php');

if (isset($_GET['ownername'])) {
    $ownername = $_GET['ownername'];
    
    $sql = "SELECT DISTINCT operatornohp FROM lcdetails WHERE ownername = '$ownername'";
    $result = mysqli_query($conn, $sql);
    
    $options = "";
    while ($row = mysqli_fetch_array($result)) {
        $options .= "<option value='".$row['operatornohp']."'>".$row['operatornohp']."</option>";
    }
    
    echo $options;
}
?>
