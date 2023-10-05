<?php
include('COMPONENT/DB/config.php');

if (isset($_GET['first_name'])) {
    $first_name = $_GET['first_name'];
    
    $sql = "SELECT DISTINCT mobile_no FROM user_teacher WHERE first_name = '$first_name'";
    $result = mysqli_query($conn, $sql);
    
    $options = "";
    while ($row = mysqli_fetch_array($result)) {
        $options .= "<option value='".$row['mobile_no']."'>".$row['mobile_no']."</option>";
    }
    
    echo $options;
}
?>
