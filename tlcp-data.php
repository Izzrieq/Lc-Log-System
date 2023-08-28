<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

$result = mysqli_query($conn, "SELECT * FROM lcdetails ORDER BY id DESC");
 
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>


    <style>
        @media (max-width:320px) {}
        @media (max-width:320px) {}

        @media (max-width:1024px) {


            th,
           
            td  {
                font-size: 0.80rem;
            }
        }


        @media (max-width:768px) {


            th,
           
            td  {
                font-size: 0.60rem;
                padding: 0;
            }

            .bg-green-500 {
                font-size: 0.60rem;
            }

            .w-40 {
                width: 126px;

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

<body class="bg-neutral-50 mb-10 ">

    <center class="font-bold text-2xl mt-6">LIST TLCP</center>
    <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-10 border border-green-700 rounded ml-3 mt-3">
        <a class="text-white no-underline" href='tlcp-add.php'>ADD TLCP</a>
    </button>
    <div class="input-group mb-4 mt-2">
        <div class="form-outline ml-3">
            <input class="w-ful rounded-md" type="text" id="combined_search" name="combined_search"
                placeholder="Search LCID or State ID" />
        </div>
    </div>
    <div class="overflow-hidden m-0 p-0 ">
        <div class="flex flex-col m-0 p-0 ">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-0 inline-block min-w-full sm:px-8 lg:px-8">
                    <table class="content min-w-full border text-center bg-white" id="table_tlcp">
                        <thead>
                            <tr class="border-b bg-gray-700">
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    STATE
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    BIZ
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">
                                    LITTLECALIPH_ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    OPERATOR_NAME
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    KINDY NUMBER
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-1 py-2 border-r">
                                    COMPLAINT COUNT
                                </th>
                                <?php if ($_SESSION['type'] === 'admin') { ?>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    ACTION
                                </th>
                                <?php } ?>
                            </tr>

                        </thead>
                        <tbody id="showlciddata">
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <?php

                $combinedSearchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

                //starting pages
                $start = 0;

                //total display
                $rows_per_pages = 50;
                
                $sql = "SELECT * FROM lcdetails WHERE lcid LIKE '%$combinedSearchQuery%' OR stateid LIKE '%$combinedSearchQuery%' ORDER BY id ASC LIMIT $start, $rows_per_pages";
                $result = mysqli_query($conn, $sql);
                $lciddata = '';
                while ($r = mysqli_fetch_array($result)){
                    $lcid = $r['lcid'];
                    $complaintCountQuery = "SELECT COUNT(*) AS complaint_count FROM complaintbliss WHERE lcid = '$lcid'";
                    $complaintCountResult = mysqli_query($conn, $complaintCountQuery);
                    $complaintCountRow = mysqli_fetch_assoc($complaintCountResult);
                    $complaintCount = $complaintCountRow['complaint_count'];
                ?>
                            <tr class="text-black">
                                <td class="border-r border-b"><?php echo $r['id']; ?></td>
                                <td class="border-r border-b"><?php echo $r['stateid']; ?></td>
                                <td class="border-r border-b"><?php echo $r['bizstype']; ?></td>
                                <td class="border-r border-b px-2"><?php echo $r['lcid']; ?></td>
                                <td class="border-r border-b px-8"><?php echo $r['operatorname']; ?></td>
                                <td class="border-r border-b px-0"><?php echo $r['kindernohp']; ?></td>
                                <td class="border-r border-b"><?php echo $complaintCount; ?></td>
                                <?php if ($_SESSION['type'] === 'admin') { ?>
                                <td class="border-r border-b p-0">
                                    <div class="flex items-center justify-between text-xs mt-2">
                                        <button
                                            class="rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-1">
                                            <a href='tlcp-info.php?id=<?php echo $r['id'];?>'>INFO</a>
                                        </button>
                                        <button
                                            class="rounded-md bg-blue-500 hover:bg-blue-700 font-bold text-white p-2 m-1">
                                            <a href='tlcp-update-form.php?id=<?php echo $r['id'];?>'>UPDATE</a>
                                        </button>
                                        <button
                                            class="rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-1">
                                            <a href='tlcp-delete.php?id=<?php echo $r['id'];?>'>DELETE</a>
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
                    url: 'COMPONENT/FUNCTION/searchtlcp.php',
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