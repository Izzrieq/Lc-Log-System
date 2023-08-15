<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

$result = mysqli_query($conn, "SELECT * FROM lcdetails ORDER BY id DESC");
 
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

</head>

<body>

    <center class="font-bold text-2xl mt-6">LIST TLCP</center>
    <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-8 border border-green-700 rounded ml-20">
        <a href='tlcp-add.php'>ADD TLCP</a>
    </button>
<div class="input-group mb-4 mt-8">
            <div class="form-outline ml-3">
                <input class="w-40 rounded-md" type="text" id="search" name="search" placeholder="Search"/>
            </div>
        </div>
    <div class="overflow-hidden">
        <div class="flex flex-col pt-3 pr-4 pl-4">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-8 lg:px-8">
                    <table class="min-w-full border text-center bg-white" id="table_tlcp">
                        <thead>
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
                        <?php
                //starting pages
                $start = 0;

                //total display
                $rows_per_pages = 35;
                
                //get total
                $records = $conn->query("SELECT * FROM lcdetails");
                $nr_of_rows = $records->num_rows;

                //calculating pages
                $pages = ceil($nr_of_rows / $rows_per_pages);

                //if the user click on pagination set a new starting point
                if(isset($_GET['page-nr'])){
                    $pages = $_GET['page-nr'] - 1;
                    $start = $pages * $rows_per_pages;
                }
                $result = mysqli_query($conn,"SELECT * FROM lcdetails LIMIT $start, $rows_per_pages") or die( mysqli_error($conn)); 
                while ($r = mysqli_fetch_array($result)){
                ?>
                        <tbody id="showlciddata">
                            <tr>
                                <td class="border-r border-b"><?php echo $r['id']; ?></td>
                                <td class="border-r border-b"><?php echo $r['stateid']; ?></td>
                                <td class="border-r border-b"><?php echo $r['bizstype']; ?></td>
                                <td class="border-r border-b px-2"><?php echo $r['lcid']; ?></td>
                                <td class="border-r border-b px-8"><?php echo $r['operatorname']; ?></td>
                                <td class="border-r border-b px-8"><?php echo $r['ownername']; ?></td>
                                <td class="border-r border-b px-2"><?php echo $r['eduemail']; ?></td>
                                <td class="border-r border-b px-0"><?php echo $r['kindernohp']; ?></td>
                                <td class="border-r border-b p-2">
                                    <div class="flex items-center justify-between mt-2">
                                        <button
                                            class="rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-2">
                                            <a href='tlcp-info.php?id=<?php echo $r['id'];?>'>INFO</a>
                                        </button>
                                        <button
                                            class="rounded-md bg-blue-500 hover:bg-blue-700 font-bold text-white p-2 m-2">
                                            <a href='tlcp-update.php?id=<?php echo $r['id'];?>'>UPDATE</a>
                                        </button>
                                        <button
                                            class="rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-2">
                                            <a href='delete.php?id=<?php echo $r['id'];?>'>DELETE</a>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                        <?php 
                }
                ?>

                    </table>
                    <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-3">Showing
                            <span><?php echo $rows_per_pages; ?> Data</span> of <?php echo $pages ?> Pages</span>
                        <ul class="inline-flex -space-x-px text-sm h-8 mr-3">
                            <li>
                                <a href="?page-nr=1"
                                    class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-white bg-gray-700 border border-gray-300 rounded-l-lg hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">First</a>
                            </li>
                            <li>
                                <?php 
                    if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){
                        ?>
                                <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-100 hover:bg-gray-800 hover:text-white dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                                <?php
                    }else{
                        ?>
                                <a href=""
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                                <?php
                    }
                ?>
                            </li>
                            <li class="flex items-center">
                                <!-- Page Number -->

                                <?php
                for($counter = 1; $counter <= $pages; $counter ++ ){
                    ?>
                                <a href="?page-nr=<?php echo $counter ?>"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?php echo $counter ?></a>
                                <?php
                }
            ?>
                            </li>
                            <!-- <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a> -->

                            <!-- Next page -->
                            <li>
                                <?php
                if(!isset($_GET['page-nr'])){
                    ?>
                                <a href="?page-nr=2"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                                <?php
                }else{
                    if($_GET['page-nr'] >= $pages){
                        ?>
                                <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                                <?php
                    }else{
                        ?>
                                <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                                <?php
                    }
                }
                ?>
                            </li>
                            <li>
                                <a href="?page-nr=<?php echo $pages ?>"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300 rounded-r-lg hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
 $(document).ready(function () {
            $('#search').on("keyup", function () {
                var search = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: 'COMPONENT/FUNCTION/searchtlcp.php',
                    data: {
                        lcid: search
                    },
                    success: function (response) {
                        $("#table_tlcp").html(response);
                    }
                });
            });
        });
</script>

</body>

</html>