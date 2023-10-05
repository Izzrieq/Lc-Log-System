<?php
include("../DB/config.php");

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

$searchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

// Pagination variables
$start = 0;
$rowsPerPage = 50;

// Modify the SQL query to search in both "code" and "name" columns
$sql = "SELECT * FROM branch WHERE code LIKE '%$searchQuery%' OR name LIKE '%$searchQuery%' ORDER BY branch_id ASC LIMIT $start, $rowsPerPage";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Handle the query error
    die("Database query failed: " . mysqli_error($conn));
}

$lciddata = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $code = mysqli_real_escape_string($conn, $row['code']); // Escape the value to prevent SQL injection

        $lciddata .= "<tr class='bg-white'>
            <td class='border-r border-b'>" . $row['branch_id'] . "</td>
            <td class='border-r border-b'>" . $row['code'] . "</td>
            <td class='border-r border-b'>" . $row['name'] . "</td>
            <td class='border-r border-b px-2'>" . $row['email_regis'] . "</td>
            <td class='border-r border-b px-8'>" . $row['address'] . "</td>
            <td class='border-r border-b px-8'>" . $row['is_active'] . "</td>
            <td class='border-r border-b px-8'>" . $row['is_active'] . "</td>";

        if ($_SESSION['type'] === 'admin') {
            $lciddata .= "<td class='border-r border-b p-2 flex items-center justify-between mt-2'>
                <a href='tlcp-info.php?branch_id=" . $row['branch_id'] . "'><button class='rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-2' type='button' name='info'>INFO</button></a>
                <a href='tlcp-update-form.php?branch_id=" . $row['branch_id'] . "'><button class='rounded-md bg-blue-500 hover:bg-blue-700 font-bold text-white p-2 m-2' type='button' name='update'>UPDATE</button></a>
                <a href='tlcp-delete.php?branch_id=" . $row['branch_id'] . "'><button class='rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-2' type='button' name='delete'>DELETE</button></a>
            </td>";
        }

        $lciddata .= "</tr>";
    }
} else {
    // No data found, display "NO DATA FOUND" with a red background
    $lciddata = "<tr class='bg-red-500 text-white'><td colspan='8' class='p-2 text-center'>NO DATA FOUND</td></tr>";
}

// Output the search results as JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode(array("lciddata" => $lciddata));
?>

