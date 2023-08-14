<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Include the Tailwind CSS script -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Other CSS links -->
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="COMPONENT/STYLE/style.css">
    <!-- ... (other CSS links) ... -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
<?php
include("..//DB/config.php");

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $start = 0;
    $rows_per_pages = 35;
    $query = "SELECT * FROM lcdetails WHERE lcid LIKE '%$searchQuery%' ORDER BY id DESC LIMIT $start, $rows_per_pages";
    $result = mysqli_query($conn, $query);
    $lciddata = '';

        while ($row = mysqli_fetch_assoc($result)) {
         $lciddata .=  "<tr class='bg-gray-100'>
        <td class='border-r text-l py-2 px-4'>".$row['id']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['stateid']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['bizstype']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['lcid']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['operatorname']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['ownername']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['status']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['yearsigned']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['datesigned']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['dateoperated']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['tlcppackage']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['annuallicense']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['eduemail']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['kindername']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['kindernohp']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['noblock']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['street']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['postcode']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['city']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['state']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['type']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['ownernohp']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['operatoraddress']."</td>   
        <td class='border-r text-l py-2 px-4'>
          <a href='bliss-updatecomplain.php?id=".$row['id']."'><button class='rounded-md bg-blue-700 text-white p-2 m-2' type='button' name='update'>Update</button></a>
          <a href='bliss-deletecomplain.php?id=".$row['id']."'><button class='rounded-md bg-red-700 text-white p-2 m-2' type='button' name='delete'>Delete</button></a>
          <a href='bliss-actioncomplain.php?id=".$row['id']."'><button class='rounded-md bg-green-700 text-white p-2 m-2' type='button' name='action'>Action</button></a>
        </td>
    
        </tr>";
        }
    } 
?>
</head>

<body>
<div class="relative overflow-x-auto shadow-md p-3">
        <!-- ... (search input and table header) ... -->
        <table class="w-full text-sm text-center text-grey-500 dark:text-red-400 border-solid border-neutral-950">
            <tbody id="showlciddata" class="bg-white text-black">
                <?php echo $lciddata; ?>
            </tbody>
        </table>
        <!-- ... (Pagination and other content) ... -->
    </div>
</body>

</html>