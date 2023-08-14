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
 include("../DB/config.php");

 $lcid = $_POST['lcid'];
 $start = 0;

 //total display
 $rows_per_pages = 5;
 
 $sql = "SELECT * FROM lcdetails WHERE lcid LIKE '$lcid%' LIMIT $start, $rows_per_pages";  
 $query = mysqli_query($conn, $sql);
 $data = '';
 
 while ($row = mysqli_fetch_assoc($query)) {
     $data .=  "<tr class='bg-gray-100'>
        <td class='border-r text-l py-2 px-4'>".$row['id']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['stateid']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['bizstype']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['lcid']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['operatorname']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['ownername']."</td>   
        <td class='border-r text-l py-2 px-4'>".$row['eduemail']."</td>  
        <td class='border-r text-l py-2 px-4'>".$row['kindernohp']."</td>  
        <td class='border-r text-l py-2 px-4'>
          <a href='tlcp-info.php?id=".$row['id']."'><button class='rounded-md bg-blue-700 text-white p-2 m-2' type='button' name='update'>Info</button></a>
          <a href='tlcp-update.php?id=".$row['id']."'><button class='rounded-md bg-red-700 text-white p-2 m-2' type='button' name='delete'>Update</button></a>
          <a href='tlcp-delete.php?id=".$row['id']."'><button class='rounded-md bg-green-700 text-white p-2 m-2' type='button' name='action'>Delete</button></a>
        </td>
    
        </tr>";
 }
 ?>
</head>

<body>
<div class="relative overflow-x-auto shadow-md p-3">
        <!-- ... (search input and table header) ... -->
        <table class="w-full text-sm text-center text-grey-500 dark:text-gray-400 border-solid border-neutral-950">
            <thead class="text-xs text-black uppercase bg-white dark:bg-gray-700 dark:text-black">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-stone-400">ID</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">State Id</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Biz Type</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Lcid</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Operator No.hp</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Owner Name</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Eduemail</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Kinder No.hp</th>
                    <th scope="col" class="px-6 py-3 bg-stone-400">Action</th>
                </tr>
            </thead>
            <tbody id="showlciddata" class="bg-white text-black">
                <?php echo $data; ?>
            </tbody>
        </table>
        <!-- ... (Pagination and other content) ... -->
    </div>
</body>

</html>
