<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

$result = mysqli_query($conn, "SELECT * FROM emergency_contact ORDER BY id DESC");
 
// Pagination
$combinedSearchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

// Pagination variables
$start = 0;
$rowsPerPage = 50;

// Determine the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$start = ($currentPage - 1) * $rowsPerPage;

$sql = "SELECT * FROM emergency_contact WHERE first_name LIKE '%$combinedSearchQuery%' OR mobile_no LIKE '%$combinedSearchQuery%' ORDER BY id ASC LIMIT $start, $rowsPerPage";
$result = mysqli_query($conn, $sql);

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>


    <style>
        @media (max-width:320px) {}

        @media (max-width:1024px) {


            th,

            td {
                font-size: 0.80rem;
            }
        }


        @media (max-width:768px) {


            th,
            td {
                font-size: 0.60rem;
                padding: 0;
            }

            .bg-green-500 {
                font-size: 0.60rem;
            }

            .w-40 {
                width: 126px;
                font-size: 0.60rem;
                padding: 5px;
            }
        }

        @media (max-width:425px) {

            th,
            td {
                font-size: 0.30rem;
                padding: 0;
            }

            .bg-green-500 {
                font-size: 0.30rem;
            }

            .w-40 {
                width: 126px;
                font-size: 0.30rem;
                padding: 5px;
            }
        }
    </style>
</head>

<body class="bg-neutral-50 mb-10">

    <center class="font-bold text-2xl mt-3">LIST CUSTOMER</center>
    <!-- <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-10 border border-green-700 rounded ml-3 mt-3">
        <a class="text-white no-underline" href='tlcp-add.php'>ADD TLCP</a>
    </button> -->
    <div class="input-group mb-3 mt-2 w-full">
        <div class="form-outline ml-3 w-1/2">
            <input class="w-1/3 rounded-md" type="text" id="combined_search" name="combined_search"
                placeholder="Search First Name or No Hp" />
        </div>
    </div>
    <div class="overflow-hidden">
        <div class="flex flex-col">
            <div class="py-0 inline-block min-w-full sm:px-4 lg:px-4">
                <table class="content min-w-full border text-center bg-white" id="table_customer">
                    <thead>
                        <tr class="border-b bg-gray-700">
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                ID
                            </th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                FIRST NAME
                            </th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                LAST NAME
                            </th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                RELATION
                            </th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                MOBILE NO.HP
                            </th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                EMAIL
                            </th>
                            <?php if ($_SESSION['type'] === 'admin') { ?>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                ACTION
                            </th>
                            <?php } ?>
                        </tr>

                    </thead>
                    <tbody id="showcustomerdata">
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <?php

                $combinedSearchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

                //starting pages
                $start = 0;

                //total display
                $rows_per_pages = 50;
                
                $sql = "SELECT * FROM emergency_contact WHERE first_name LIKE '%$combinedSearchQuery%' OR mobile_no LIKE '%$combinedSearchQuery%' ORDER BY id ASC LIMIT $start, $rows_per_pages";
                $result = mysqli_query($conn, $sql);
                $customerdata = '';
                while ($r = mysqli_fetch_array($result)){
                ?>
                        <tr class="text-black">
                            <td class="border-r border-b"><?php echo $r['id']; ?></td>
                            <td class="border-r border-b"><?php echo $r['first_name']; ?></td>
                            <td class="border-r border-b"><?php echo $r['last_name']; ?></td>
                            <td class="border-r border-b"><?php echo $r['relation']; ?></td>
                            <td class="border-r border-b"><?php echo $r['mobile_no']; ?></td>
                            <td class="border-r border-b px-0"><?php echo $r['email']; ?></td>
                            <?php if ($_SESSION['type'] === 'admin') { ?>
                            <td class="border-r border-b p-0">
                                <div class="flex items-center justify-between mt-2">
                                    <button class="rounded-md bg-gray-500 hover:bg-gray-700 font-bold p-2 m-1">
                                        <a class="text-white text-decoration-none"
                                            href='customer-info.php?parent_id=<?php echo $r['parent_id'];?>'>INFO</a>
                                    </button>
                                    <button class="rounded-md bg-blue-500 hover:bg-blue-700 font-bold p-2 m-1">
                                        <a class="text-white text-decoration-none"
                                            href='tlcp-update-form.php?id=<?php echo $r['id'];?>'>UPDATE</a>
                                    </button>
                                    <button class="rounded-md bg-red-500 hover:bg-red-700 font-bold p-2 m-1">
                                        <a class="text-white text-decoration-none"
                                            href='tlcp-delete.php?id=<?php echo $r['id'];?>'>DELETE</a>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>

                        </tr>
                    </tbody>
                    <?php 
                }
                ?>

                </table>
                <div
                    class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 no-underline">
                    <!-- Pagination links -->
                    <?php
        $sqlCount = "SELECT COUNT(*) AS total FROM emergency_contact WHERE first_name LIKE '%$combinedSearchQuery%' OR mobile_no LIKE '%$combinedSearchQuery%'";
        $resultCount = mysqli_query($conn, $sqlCount);
        $rowCount = mysqli_fetch_assoc($resultCount)['total'];

        $totalPages = ceil($rowCount / $rowsPerPage);

        if ($totalPages > 1) {
            echo "<div class='flex flex-1 justify-between sm:hidden'>";
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo "<a href='tlcp-data.php?page=$prevPage' class='relative inline-flex items-center rounded-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'>Previous</a>";
            }
            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo "<a href='tlcp-data.php?page=$nextPage' class='relative ml-3 inline-flex items-center rounded-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'>Next</a>";
            }
            echo "</div>";

            echo "<div class='hidden sm:flex sm:flex-1 sm:items-center sm:justify-between'>";
            echo "<div>";
            echo "<p class='text-sm text-gray-700'>Showing <span class='font-medium'>$start</span> to <span class='font-medium'>$rowCount</span> of <span class='font-medium'>$rowCount</span> results</p>";
            echo "</div>";
            echo "<div>";
            echo "<nav class='isolate inline-flex -space-x-px rounded-md shadow-sm no-underline' aria-label='Pagination'>";
            
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = $i === $currentPage ? 'bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0';
                echo "<a href='list-task.php?page=$i' class='relative inline-flex items-center px-4 py-2 text-sm font-semibold $activeClass'>$i</a>";
            }
            
            echo "</nav>";
            echo "</div>";
            echo "</div>";
        }
        ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#combined_search').on("keyup", function () {
                var combinedSearch = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: 'COMPONENT/FUNCTION/searchcustomer.php',
                    data: {
                        combined_search: combinedSearch
                    },
                    success: function (response) {
                        $("#table_tlcp").html(response);
                    }
                });
            });
        });
    </script>
    <?php
    include "COMPONENT/footer.php";
?>
</body>

</html>