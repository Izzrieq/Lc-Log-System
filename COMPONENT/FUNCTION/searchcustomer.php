<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER DATA</title>

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

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

$searchQuery = isset($_POST['combined_search']) ? $_POST['combined_search'] : '';

$sql = "SELECT * FROM emergency_contact WHERE first_name LIKE '%$searchQuery%' ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    // Handle the query error
    die("Database query failed: " . mysqli_error($conn));
}

$customerdata = '';

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

// Return the complete HTML table structure
echo "<table class='w-full text-center text-grey-500 dark:text-gray-400'>
        <thead class='text-center uppercase'>
            <tr class='border-b bg-gray-700'>
                <th scope='col' class='text-md font-medium text-white px-2 py-2 border-r'>
                    ID
                </th>
                <th scope='col' class='text-md font-medium text-white px-2 py-2 border-r'>
                    STATE_ID
                </th>
                <th scope='col' class='text-md font-medium text-white px-4 py-2 border-r'>
                    BIZ_TYPE
                </th>
                <th scope='col' class='text-md font-medium text-white px-8 py-2 border-r'>
                    LITTLECALIPH_ID
                </th>
                <th scope='col' class='text-md font-medium text-white px-4 py-2 border-r'>
                    OPERATOR_NAME
                </th>
                <th scope='col' class='text-md font-medium text-white px-4 py-2 border-r'>
                    KINDERGARTEN NUMBER
                </th>
                <th scope='col' class='text-md font-medium text-white px-2 py-2 border-r'>
                    COMPLAINT COUNT
                </th>
                <th scope='col' class='text-md font-medium text-white px-4 py-2 border-r'>
                    ACTION
                </th>
            </tr>
        </thead>
        <tbody class='bg-white text-black'>
            $lciddata
        </tbody>
    </table>";
?>
</head>

<body>
<?php
    if (mysqli_num_rows($result) > 0) {
    ?>
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
                    KINDERGARTEN NUMBER
                </th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                    COMPLAINT COUNT
                </th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">
                    ACTION
                </th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            <?php echo $lciddata; ?>
        </tbody>
    </table>
    <?php
    } else {
        // No rows found, handle this case
        echo "<h1 class='text-center text-danger mt-5'>No data found</h1>";
    }
    ?>
</body>

</html>