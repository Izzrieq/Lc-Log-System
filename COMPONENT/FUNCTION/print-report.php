<?php
    include "../DB/config.php"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <center>
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-black">
            <tr>
                <th>NO.</th>
                <th>LC ID</th>
                <th>TYPE OF COMPLAIN</th>
                <th>CATEGORY</th>
                <th>DATE/TIME</th>
                <th>TOTAL</th>
            </tr>

            <?php   
    $sql = "SELECT * FROM complaintbliss";
    $choice = $_POST["choice"];
    $lcid = $_POST["lcid"];
	$category = $_POST["category"];
    $type = $_POST["type"];
	$date = date("Y-m-d H:i:s");
    $year = 2019;  //laporan untuk tahun semasa
    $listmonth = array("JAN","FEB","MAR","APR","MAY", 
                     "JUNE","JULY","AUG","SEPT","OCT","NOV","DEC");
    
    switch ($choice) {
        case 1 :  $syarat = ""; 
                  $tajuk = ""; break;     
        case 2 :  $syarat = "where category = '$category' "; 
                  $tajuk = "REPORT ACCORD TO CATEGORY";break;
        case 3 :  $syarat = "where type = '$type' "; 
                  $tajuk = "REPORT ACCORD TO TYPE";break;
    }
    $bil = 1;
    ?>

            <tr>
                <td><?php echo $bil; ?></td>
                <td><?php echo $lcid; ?></td>
                <td><?php echo $category; ?></td>
                <td><?php echo $type; ?></td>               
                <td><?php echo $date; ?></td>
                <td>

    <?php 
        $bil = $bil + 1;  
    ?>
                </td>
            </tr>
            <tr>
                <td colspan="8" align="right">JUMLAH KESELURUHAN</td>
                <td>RM <?php echo number_format($jumlah_keseluruhan, 2);?></td>
            </tr>
            <caption><?php echo $tajuk; ?></caption>
        </table><button style="background-image: url(image/printer-icon.png);" onclick="window.print()">Cetak</button>
    </div>
    </center>
   

</body>

</html> 