<?php
include('../COMPONENT/DB/config.php');

if (isset($_GET['branch_id'])) {
    $branch_id = $_GET['branch_id'];
    
    $sql = "SELECT DISTINCT first_name FROM user_teacher WHERE branch_id = '$branch_id'";
    $result = mysqli_query($conn, $sql);
    
    $options = "";
    while ($row = mysqli_fetch_array($result)) {
        $options .= "<option value='".$row['first_name']."'>".$row['first_name']."</option>";
    }
    
    echo $options;
}
?>
