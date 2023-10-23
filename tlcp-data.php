<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(array("error" => "You must log in first."));
    exit;
}
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

// Prepare the main SQL query with placeholders
$sql = "SELECT branch.branch_id, branch.code, branch.name, branch.email_regis, branch.address, branch.is_active, 
               (SELECT COUNT(*) FROM complaintbliss WHERE CAST(complaintbliss.lcid AS CHAR) = CAST(branch.code AS CHAR)) AS complaintCount
        FROM branch
        WHERE branch.code LIKE ? OR branch.name LIKE ?
        LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);

// Check for errors in preparing the statement
if ($stmt === false) {
    die("Prepared statement error: " . mysqli_error($conn));
}

// Bind values to placeholders for the main query
$combinedSearchQuery = isset($_POST['combined_search']) ? "%" . $_POST['combined_search'] . "%" : "%"; // Default to all records if search query is not provided
mysqli_stmt_bind_param($stmt, "ssii", $combinedSearchQuery, $combinedSearchQuery, $start, $rowsPerPage);

// Execute the prepared statement for the main query
if (mysqli_stmt_execute($stmt)) {
    // Fetch the results
    $mainResult = mysqli_stmt_get_result($stmt); 
} else {
    die("Error executing main prepared statement: " . mysqli_error($conn));
}

// Close the main statement
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <style>

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

<body class="bg-neutral-50 mb-10 ">

    <center class="font-bold text-2xl mt-3">LIST TLCP</center>
    <!-- <button
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-10 border border-green-700 rounded ml-3 mt-3">
        <a class="text-white no-underline" href='tlcp-add.php'>ADD TLCP</a>
    </button> -->
    <div class="input-group mb-3 mt-2">
        <div class="form-outline ml-3">
            <input class="w-ful rounded-md" type="text" id="combined_search" name="combined_search" placeholder="Search CODE or NAME" />
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
                                    BRANCH ID
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    CODE
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    NAME
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">
                                    EMAIL
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    ADDRESS
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                                    ACTIVE
                                </th>
                                <th scope="col" class="text-md font-medium text-white px-1 py-2 border-r">
                                    COMPLAINT
                                </th>
                                <?php if ($_SESSION['type'] === 'admin') { ?>
                                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                    ACTION
                                </th>
                                <?php } ?>
                            </tr>

                        </thead>
                        <tbody id="showlciddata">
                            <?php
                            $sql = "SELECT * FROM branch WHERE code LIKE '%$combinedSearchQuery%' OR name LIKE '%$combinedSearchQuery%' ORDER BY branch_id ASC LIMIT $start, $rowsPerPage";
                            $result = mysqli_query($conn, $sql);
                            
                            if ($result === false) {
                                die("Error executing main SQL query: " . mysqli_error($conn));
                            }
                            while ($r = mysqli_fetch_array($result)) {
                                $branch_id = $r['branch_id'];
                            
                                // Use a subquery to count complaints for each branch
                                $complaintCountQuery = "SELECT COUNT(*) AS complaint_count FROM complaintbliss WHERE lcid = (SELECT code FROM branch WHERE branch_id = ?)";
                                $stmt = mysqli_prepare($conn, $complaintCountQuery);
                            
                                if ($stmt === false) {
                                    die("Error preparing inner SQL statement: " . mysqli_error($conn));
                                }
                            
                                // Bind the parameter
                                mysqli_stmt_bind_param($stmt, "i", $branch_id);
                            
                                // Execute the prepared statement
                                $executeResult = mysqli_stmt_execute($stmt);
                            
                                if ($executeResult === false) {
                                    die("Error executing inner SQL statement: " . mysqli_error($conn));
                                }
                            
                                // Get the result
                                $complaintCountResult = mysqli_stmt_get_result($stmt);
                            
                                if ($complaintCountResult === false) {
                                    die("Error fetching complaint count result: " . mysqli_error($conn));
                                }
                            
                                $complaintCountRow = mysqli_fetch_assoc($complaintCountResult);
                            
                                if ($complaintCountRow !== null && isset($complaintCountRow['complaint_count'])) {
                                    $complaintCount = $complaintCountRow['complaint_count'];
                                } else {
                                    $complaintCount = 0; // Set the count to 0 if no complaints are found
                                }
                            
                                // Debug output
                               // echo "Branch ID: " . $branch_id . ", Complaint Count: " . $complaintCount . "<br>";
                            ?>
                            <tr class="text-black">
                                <td class="border-r border-b"><?php echo $r['branch_id']; ?></td>
                                <td class="border-r border-b"><?php echo $r['code']; ?></td>
                                <td class="border-r border-b"><?php echo $r['name']; ?></td>
                                <td class="border-r border-b px-2"><?php echo $r['email_regis']; ?></td>
                                <td class="border-r border-b px-8"><?php echo $r['address']; ?></td>
                                <td class="border-r border-b px-0"><?php 
                                if ($r['is_active'] == '1'){
                                    echo "ACTIVE";
                                }else{
                                    echo "UNAVAILABLE";
                                }
                                ?></td>
                                <td class="border-r border-b"><?php echo $complaintCount; ?></td>
                                <?php if ($_SESSION['type'] === 'admin') { ?>
                                <td class="border-r border-b p-0">
                                    <div class="flex items-center justify-between mt-2">
                                        <button class="rounded-md bg-gray-500 hover:bg-gray-700 font-bold p-2 m-1">
                                            <a class="text-white text-decoration-none"
                                                href='tlcp-info.php?branch_id=<?php echo $r['branch_id'];?>'>INFO</a>
                                        </button>
                                        <button class="rounded-md bg-red-500 hover:bg-red-700 font-bold p-2 m-1">
                                            <a class="text-white text-decoration-none"
                                                href='tlcp-delete.php?branch_id=<?php echo $r['branch_id'];?>'>DELETE</a>
                                        </button>
                                    </div>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php
                            mysqli_stmt_close($stmt);
                        } // End of the while loop ?>
                        </tbody>
                    </table>
                    <div
                        class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 no-underline">
                        <!-- Pagination links -->
                        <?php
                            $sqlCount = "SELECT COUNT(*) AS total FROM branch WHERE code LIKE '%$combinedSearchQuery%' OR name LIKE '%$combinedSearchQuery%'";
                            $resultCount = mysqli_query($conn, $sqlCount);
                            $rowCount = mysqli_fetch_assoc($resultCount)['total'];
                            $startId = ($currentPage - 1) * $rowsPerPage + 1;
                            $endId = min($currentPage * $rowsPerPage, $rowCount);

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
                                echo "<p class='text-sm text-gray-700'>Showing <span class='font-medium'>$startId</span> to <span class='font-medium'>$endId</span> of <span class='font-medium'>$rowCount</span> results</p>";
                                echo "</div>";
                                echo "<div>";
                                echo "<nav class='isolate inline-flex -space-x-px rounded-md shadow-sm no-underline' aria-label='Pagination'>";
                               // Previous Page
                                if ($currentPage > 1) {
                                    echo "<a href='tlcp-data.php?page=" . ($currentPage - 1) . "' class='relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-blue-50 hover:bg-gray-50 focus:outline-offset-0'>&laquo; Previous</a>";
                                }

                                // Previous Page Number (if current page is greater than 2)
                                if ($currentPage > 2) {
                                    echo "<a href='tlcp-data.php?page=" . ($currentPage - 1) . "' class='relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-blue-50 hover:bg-gray-50 focus:outline-offset-0'>" . ($currentPage - 1) . "</a>";
                                }

                                // Current Page Number
                                echo "<span class='relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-blue-300 hover:bg-gray-50 focus:outline-offset-0'>$currentPage</span>";

                                // Next Page Number (if current page is less than total pages minus 1)
                                if ($currentPage < ($totalPages - 1)) {
                                    echo "<a href='tlcp-data.php?page=" . ($currentPage + 1) . "' class='relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-blue-50 hover:bg-gray-50 focus:outline-offset-0'>" . ($currentPage + 1) . "</a>";
                                }

                                // Next Page
                                if ($currentPage < $totalPages) {
                                    echo "<a href='tlcp-data.php?page=" . ($currentPage + 1) . "' class='relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 bg-blue-50 hover:bg-gray-50 focus:outline-offset-0'>Next &raquo;</a>";
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
            var timer;
            
            $('#combined_search').on("input", function () {
                clearTimeout(timer);
                var combinedSearch = $(this).val();
                
                // Use a timeout to wait for the user to finish typing before sending a request
                timer = setTimeout(function () {
                    console.log("Search query: " + combinedSearch); // Debugging statement
                    $.ajax({
                        method: 'POST',
                        url: 'Ajax/searchtlcp.php',
                        data: {
                            combined_search: combinedSearch
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log(response); // Debugging statement
                            if (response && response.lciddata) {
                                $("#table_tlcp tbody").html(response.lciddata);
                            } else {
                                console.error('Invalid or missing data in the response.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX request failed:', status, error);
                        }
                    });
                }, 500); // Wait for 500ms of inactivity before sending the request
            });
        });
        </script>
        <?php
    include "COMPONENT/footer.php";
?>
</body>

</html>