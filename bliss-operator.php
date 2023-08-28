<?php
include "COMPONENT/DB/config.php";
include "COMPONENT/header.php" ;

session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

$result = mysqli_query($conn, "SELECT * FROM complaintbliss ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="COMPONENT/STYLE/style.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>

</head>

<script>
    const searchButton = document.getElementById('search-button');
    const searchInput = document.getElementById('search-input');
    searchButton.addEventListener('click', () => {
        const inputValue = searchInput.value;
        alert(inputValue);
    });
</script>

<body class="bg-neutral-50" style="height: 120vh;">
    <!-- navbar -->
    <center class="font-bold text-2xl mt-2">LIST COMPLAINT</center>
    <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-10 border border-green-700 rounded ml-3 mt-3">
        <a class="text-white no-underline" href='bliss-addcomplain.php'>ADD ISSUE</a>
    </button>
    <div class="input-group mb-4 mt-2">
        <div class="form-outline ml-3">
            <input class="w-ful rounded-md" type="text" id="getName" placeholder="Search"/>
        </div>
    </div>
    <div class="relative shadow-md p-3">
        <div class="overflow-hidden">
            <div class="flex flex-col pt-2 pr-4 pl-4">
                <div class="overflow-x-auto sm:-mx-8 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-8 lg:px-8">
                        <table class="min-w-full border text-center bg-white" id="table-data">
                            <thead>
                                <tr class="border-b bg-gray-700">
                                    <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                        ID
                                    </th>
                                    <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                        DATE/TIME
                                    </th>
                                    <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                        CUSTOMER NAME
                                    </th>
                                    <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">
                                        CUSTOMER NO.HP
                                    </th>
                                    <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                        CATEGORY
                                    </th>
                                    <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                        TYPE
                                    </th>
                                    <?php if ($_SESSION['type'] === 'admin') { ?>
                                    <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                        STATUS
                                    </th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="showdata" class="bg-white text-black">
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <?php

                //starting pages
                $start = 0;

                //total display
                $rows_per_pages = 5;

                $result = mysqli_query($conn,"SELECT * FROM complaintbliss LIMIT $start, $rows_per_pages"); 
                while ($r = mysqli_fetch_array($result)){
                ?>
                                <tr>
                                    <td class="border-r text-l"><?php echo $r['id']; ?></td>
                                    <td class="border-r text-l"><?php echo $r['date']; ?></td>
                                    <td class="border-r text-l"><?php echo $r['cname']; ?></td>
                                    <td class="border-r text-l"><?php echo $r['cnohp']; ?></td>
                                    <td class="border-r text-l"><?php echo $r['category']; ?></td>
                                    <td class="border-r text-l"><?php echo $r['type']; ?></td>
                                    <?php if ($_SESSION['type'] === 'admin') { ?>
                                    <td class="d-flex justify-content-center">
                                    <a href='bliss-infocomplaint.php?id=<?php echo $r['id'];?>'><button
                                                class="rounded-md bg-gray-400 text-white p-2 m-2">Info</button></a>
                                        <a href='bliss-updatecomplaint-form.php?id=<?php echo $r['id'];?>'><button
                                                class="rounded-md bg-blue-700 text-white p-2 m-2">Update</button></a>
                                        <a href='bliss-deletecomplaint.php?id=<?php echo $r['id'];?>'
                                            onclick="return confirm('Are you sure you want to delete?')"><button
                                                class="rounded-md bg-red-700 text-white p-2 m-2">Delete</button></a>
                                        <a href='bliss-actioncomplaint.php?id=<?php echo $r['id'];?>'><button
                                                class="rounded-md bg-green-700 text-white p-2 m-2">Email</button></a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                            <?php
                }
                ?>
                        </table>
<<<<<<< HEAD
                        <button
                            class="bg-blue-500 hover:bg-blue-700 font-bold mt-2 py-2 px-3 border border-blue-700 rounded">
                            <a href="bliss-addcomplaint.php" class="text-white">ADD ISSUE</a>
                        </button>
                        <nav class="flex items-center justify-between pt-2" aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-3 mb-8">Showing
                                <span><?php echo $rows_per_pages; ?> Data</span> of <?php echo $pages ?> Pages</span>
                            <ul class="inline-flex -space-x-px text-sm h-8 mr-3 mb-8">
                                <li>
                                    <a href="?page-nr=1"
                                        class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-white bg-gray-700 border border-gray-300 rounded-l-lg hover:bg-gray-800 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">First</a>
                                </li>
                                <li>
                                    <?php 
                    if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){
                        ?>
                                    <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                                    <?php
                    }else{
                        ?>
                                    <a href=""
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-gray-700 border border-gray-300  hover:bg-gray-800 hover:text-white dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
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
=======
>>>>>>> ce06da19db031a2aa52b755c1525b698e82828c0
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#getName').on("keyup", function () {
                                var getName = $(this).val();
                                $.ajax({
                                    method: 'POST',
                                    url: 'COMPONENT/FUNCTION/searchajax.php',
                                    data: {
                                        cname: getName
                                    },
                                    success: function (response) {
                                        $("#table-data").html(response);
                                    }
                                });
                            });
                        });
                    </script>
</body>

</html>
<?php include "COMPONENT/footer.php" ?>