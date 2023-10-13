<?php
include_once "../COMPONENT/DB/config.php";

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

$searchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

// Pagination variables
$start = 0;
$rowsPerPage = 50;

$sql = "SELECT * FROM branchdetails WHERE lcid LIKE '%$searchQuery%' ORDER BY branch_id ASC LIMIT $start, $rowsPerPage";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Handle the query error
    die("Database query failed: " . mysqli_error($conn));
}

$lciddata = '';

while ($row = mysqli_fetch_array($result)) {
    $lcid = mysqli_real_escape_string($conn, $row['lcid']); // Escape the value to prevent SQL injection

    $complaintCountQuery = "SELECT COUNT(*) AS complaint_count FROM complaintbliss WHERE lcid = '$lcid'";
    $complaintCountResult = mysqli_query($conn, $complaintCountQuery);

    if ($complaintCountResult === false) {
        die("Error querying complaint count: " . mysqli_error($conn));
    }

    $complaintCountRow = mysqli_fetch_assoc($complaintCountResult);
    $complaintCount = $complaintCountRow['complaint_count'];

    $lciddata .= "<tr class='bg-white'>
        <td class='border-r border-b'>" . $row['branch_id'] . "</td>
        <td class='border-r border-b'>" . $row['stateid'] . "</td>
        <td class='border-r border-b'>" . $row['bizstype'] . "</td>
        <td class='border-r border-b px-2'>" . $row['lcid'] . "</td>
        <td class='border-r border-b px-8'>" . $row['operatorname'] . "</td>
        <td class='border-r border-b px-0'>" . $row['kindernohp'] . "</td>
        <td class='border-r border-b'>" . $complaintCount . "</td>";

    if ($_SESSION['type'] === 'admin') {
        $lciddata .= "<td class='border-r border-b p-2 flex items-center justify-center mt-2'>
            <a href='tlcp-info.php?branch_id=" . $row['branch_id'] . "'><button class='rounded-md bg-gray-500 hover-bg-gray-700 font-bold text-white p-2 m-2' type='button' name='info'>INFO</button></a>
            <a href='tlcp-delete.php?branch_id=" . $row['branch_id'] . "'><button class='rounded-md bg-red-500 hover-bg-red-700 font-bold text-white p-2 m-2' type='button' name='delete'>DELETE</button></a>
        </td>";
    }

    $lciddata .= "</tr>";
}

// Check if $lciddata is empty (no results found)
if (empty($lciddata)) {
    $lciddata = "<tr class='bg-red-500 text-white'><td colspan='8' class='p-2 text-center'>NO DATA FOUND</td></tr>";
}

$response = array("lciddata" => $lciddata);
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($response);
exit;   
?>
