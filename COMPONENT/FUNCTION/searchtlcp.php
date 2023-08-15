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

    $searchQuery = $_POST['lcid'];
    $start = 0;

    //total display per page
    $rows_per_pages = 35;

    $sql = "SELECT * FROM lcdetails WHERE lcid LIKE '%$searchQuery%' ORDER BY id ASC LIMIT $start, $rows_per_pages";
    $result = mysqli_query($conn, $sql);
    $lciddata = '';

        while ($row = mysqli_fetch_assoc($result)) {
         $lciddata .=  "<tr class='bg-white'>
        <td class='border-r border-b'>".$row['id']."</td>
        <td class='border-r border-b'>".$row['stateid']."</td>
        <td class='border-r border-b'>".$row['bizstype']."</td>
        <td class='border-r border-b px-2'>".$row['lcid']."</td>
        <td class='border-r border-b px-8'>".$row['operatorname']."</td>
        <td class='border-r border-b px-8'>".$row['ownername']."</td>    
        <td class='border-r border-b px-2'>".$row['eduemail']."</td>   
        <td class='border-r border-b px-0'>".$row['kindernohp']."</td>   
        <td class='border-r border-b p-2 flex items-center justify-between mt-2'>
          <a href='tlcp-info.php?id=".$row['id']."'><button class='rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-2' type='button' name='info'>Update</button></a>
          <a href='tlcp-update.php?id=".$row['id']."'><button class='rounded-md bg-blue-500 hover:bg-blue-700 font-bold text-white p-2 m-2' type='button' name='update'>Delete</button></a>
          <a href='delete.php?id=".$row['id']."'><button class='rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-2' type='button' name='delete'>Action</button></a>
        </td>
    
        </tr>";
        }
?>
</head>

<body>
    <!-- <div class="relative overflow-x-auto shadow-md p-3"> -->
    <!-- ... (search input and table header) ... -->
    <div class="overflow-hidden">
        <div class="flex flex-col">
            <div class="overflow-x-auto lg:-mx-8">
                <div class="py-0 inline-block min-w-full sm:px-8 lg:px-8">
                    <table class="w-full text-center text-grey-500 dark:text-gray-400">
                        <thead class="text-center uppercase">
                            <tr class="border-b bg-gray-700">
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    STATE_ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    BIZ_TYPE
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">
                                    LITTLECALIPH_ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    OPERATOR_NAME
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    OWNER_NAME
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    EDU_EMAIL
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    KINDERGARTEN NUMBER
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    ACTION
                                </th>
                            </tr>

                        </thead>
                        </thead>
                        <tbody id="showlciddata" class="bg-white text-black">
                            <?php echo $lciddata; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ... (Pagination and other content) ... -->
</body>

</html>