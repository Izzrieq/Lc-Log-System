<?php
include "../DB/config.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    @media print {
  @page {
    size: landscape;
  }
  body {
    font-size: 10px; /* Adjust the font size as needed */
  }

  /* Specific styling for elements */
  table {
    font-size: 8px; /* Adjust the font size for tables */
  }
}
</style>
<body class="m-0 p-0">
    <center>
        <table class="w-full text-left text-black">
            <tr class="text-black uppercase bg-gray-700 border-b">
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Id</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Date</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Customer Name</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Customer Nohp</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Category</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Type</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Details</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Lcid</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Lc Owner</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">Owner Nohp</th>
            </tr>

            <?php
    $pilihan = $_POST["pilihan"];
	$lcid = $_POST["lcid"];
	$bulan = $_POST["bulan"];
    $tahun = 2023;  //laporan untuk tahun semasa
    $senarai = array("DUMMY","JAN","FEB","MAR","APR","MAY", 
                     "JUN","JUL","AUG","SEP","OCT","NOV","DEC");
    $namabulan = $senarai[$bulan];
    $sql = "SELECT * FROM complaintbliss ";

switch ($pilihan) {
    case 1:
        $syarat = "";
        $tajuk = "";
        break;
    case 2:
        $syarat = " WHERE complaintbliss.lcid = '$lcid' ";
        $tajuk = "LAPORAN MENGIKUT LCID";
        break;
    case 3:
        $syarat = " WHERE MONTH(date) = $bulan";
        $tajuk = "LAPORAN BULAN $namabulan";
        break;
    case 4:
        $syarat = " WHERE complaintbliss.lcid = '$lcid' AND MONTH(date) = $bulan";
        $tajuk = "LAPORAN BULAN $namabulan DAN MENGIKUT LCID";
        break;
    }
    $bil = 1;
    $sql = $sql.$syarat;  // cantum
    // Debugging: Print the generated SQL query
    //echo "Generated SQL Query: $sql<br>";

    // Execute the query and handle errors
    $data = mysqli_query($conn, $sql);
    if (!$data) {
        die("Query error: " . mysqli_error($conn));
    }      
	while ($r = mysqli_fetch_array($data)) {	
    ?>

            <tr>
                <td class="border-r text-l"><?php echo $bil; ?></td>
                <td class="border-r text-l"><?php echo $r['date']; ?></td>
                <td class="border-r text-l"><?php echo $r['cname']; ?></td>
                <td class="border-r text-l"><?php echo $r['cnohp']; ?></td>
                <td class="border-r text-l"><?php echo $r['category']; ?></td>
                <td class="border-r text-l"><?php echo $r['type']; ?></td>
                <td class="border-r text-l"><?php echo $r['details']; ?></td>
                <td class="border-r text-l"><?php echo $r['lcid']; ?></td>
                <td class="border-r text-l"><?php echo $r['lcowner']; ?></td>
                <td class="border-r text-l"><?php echo $r['ownernohp']; ?></td>
                    <?php 
        $bil = $bil + 1; 
        }  // while    
    ?>
                </td>
            </tr>
        </table><button onclick="window.print()" class="py-2 m-2 bg-black text-white w-1/6">Print</button>
    </center>
</body>

</html>