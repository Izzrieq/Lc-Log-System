<?php
include("../COMPONENT/DB/config.php");

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

$searchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

// Pagination variables
$start = 0;
$rowsPerPage = 50;

$sql = "SELECT * FROM emergency_contact WHERE first_name LIKE '%$searchQuery%' ORDER BY id ASC LIMIT $start, $rowsPerPage";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Handle the query error
    die("Database query failed: " . mysqli_error($conn));
}

$customerdata = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $first_name = mysqli_real_escape_string($conn, $row['first_name']); // Escape the value to prevent SQL injection

        $customerdata .= "<tr class='bg-white'>
            <td class='border-r border-b''>" . $row['id'] . "</td>
            <td class='border-r border-b'>" . $row['first_name'] . "</td>
            <td class='border-r border-b'>" . $row['last_name'] . "</td>
            <td class='border-r border-b'>" . $row['relation'] . "</td>
            <td class='border-r border-b'>" . $row['mobile_no'] . "</td>
            <td class='border-r border-b'>" . $row['email'] . "</td>";

        if ($_SESSION['type'] === 'admin') {
            $customerdata .= "<td class='border-r border-b p-2 flex items-center justify-between mt-2'>
                <a href='customer-info.php?parent_id=" . $row['parent_id'] . "'><button class='rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-2' type='button' name='info'>INFO</button></a>
                <a href='customer-delete.php?parent_id=" . $row['parent_id'] . "'><button class='rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-2' type='button' name='delete'>DELETE</button></a>
            </td>";
        }

        $customerdata .= "</tr>";
    }
} else {
    // No data found, display "NO DATA FOUND" with a red background
    $customerdata = "<tr class='bg-red-500 text-white'><td colspan='8' class='p-2 text-center'>NO DATA FOUND</td></tr>";
}
// Output the search results as JSON
echo json_encode(array("customerdata" => $customerdata));
?>
