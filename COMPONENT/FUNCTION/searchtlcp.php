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

$sql = "SELECT * FROM lcdetails WHERE lcid LIKE '%$searchQuery%' ORDER BY id ASC LIMIT $start, $rowsPerPage";
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
        die("Complaint count query failed: " . mysqli_error($conn));
    }
    
    $complaintCountRow = mysqli_fetch_assoc($complaintCountResult);
    $complaintCount = $complaintCountRow['complaint_count'];
    $lciddata .= "<tr class='bg-white'>
        <td class='border-r border-b'>" . $row['id'] . "</td>
        <td class='border-r border-b'>" . $row['stateid'] . "</td>
        <td class='border-r border-b'>" . $row['bizstype'] . "</td>
        <td class='border-r border-b px-2'>" . $row['lcid'] . "</td>
        <td class='border-r border-b px-8'>" . $row['operatorname'] . "</td>
        <td class='border-r border-b px-0'>" . $row['kindernohp'] . "</td>
        <td class='border-r border-b'>" . $complaintCount . "</td>";

    if ($_SESSION['type'] === 'admin') {
        $lciddata .= "<td class='border-r border-b p-2 flex items-center justify-between mt-2'>
            <a href='tlcp-info.php?id=" . $row['id'] . "'><button class='rounded-md bg-gray-500 hover:bg-gray-700 font-bold text-white p-2 m-2' type='button' name='info'>INFO</button></a>
            <a href='tlcp-update-form.php?id=" . $row['id'] . "'><button class='rounded-md bg-blue-500 hover:bg-blue-700 font-bold text-white p-2 m-2' type='button' name='update'>UPDATE</button></a>
            <a href='tlcp-delete.php?id=" . $row['id'] . "'><button class='rounded-md bg-red-500 hover:bg-red-700 font-bold text-white p-2 m-2' type='button' name='delete'>DELETE</button></a>
        </td>";
    }

    $lciddata .= "</tr>";
}

// Output the search results as JSON
echo json_encode(array("lciddata" => $lciddata));
?>
