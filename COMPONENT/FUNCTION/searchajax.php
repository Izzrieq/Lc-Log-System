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
    <!-- <link rel="stylesheet" href="COMPONENT/STYLE/style.css"> -->
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

 $cname = $_POST['cname'];
 $start = 0;

 //total display
 $rows_per_pages = 5;
 
 $sql = "SELECT * FROM complaintbliss WHERE cname LIKE '$cname%' LIMIT $start, $rows_per_pages";  
 $query = mysqli_query($conn, $sql);
 $data = '';
 
 while ($row = mysqli_fetch_assoc($query)) {
     $data .=  "<tr class='bg-gray-100'>
        <td class='border-r text-l py-2 px-4'>".$row['id']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['date']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['cname']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['cnohp']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['category']."</td>
        <td class='border-r text-l py-2 px-4'>".$row['type']."</td>   
        <td class='border-r text-l py-2 px-2'>
          <a href='bliss-updatecomplain.php?id=".$row['id']."'><button class='rounded-md bg-blue-700 text-white p-2 m-2' type='button' name='update'>Update</button></a>
          <a href='bliss-deletecomplain.php?id=".$row['id']."'><button class='rounded-md bg-red-700 text-white p-2 m-2' type='button' name='delete'>Delete</button></a>
          <a href='bliss-actioncomplain.php?id=".$row['id']."'><button class='rounded-md bg-green-700 text-white p-2 m-2' type='button' name='action'>Action</button></a>
        </td>
    
        </tr>";
 }
 ?>
</head>

<body>
    <!-- ... (search input and table header) ... -->
    <!-- <div class="relative overflow-x-auto shadow-md p-3"> -->
    <table class="w-full text-centerw-full text-center text-grey-500 dark:text-gray-400">
        <thead class="text-black uppercase bg-white dark:bg-gray-700 dark:text-black">
            <tr class="border-b bg-gray-700">
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">ID</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">DATE/TIME</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">CUSTOMER NAME</th>
                <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">CUSTOMER NO.HP</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">CATEGORY</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">TYPE</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">STATUS</th>
            </tr>
        </thead>
        <tbody id="showdata" class="bg-white text-black">
            <?php echo $data; ?>
        </tbody>
    </table>
    <!-- ... (Pagination and other content) ... -->
    </div>
</body>

</html>