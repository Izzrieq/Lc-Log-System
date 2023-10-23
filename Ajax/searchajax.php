<?php 
 include("../COMPONENT/DB/config.php");

 session_start(); // Start the session

 $cname = $_POST['cname'];
 $start = 0;

 //total display
 $rows_per_pages = 5;
 
 $sql = "SELECT * FROM complaintbliss WHERE cname LIKE '$cname%' LIMIT $start, $rows_per_pages";  
 $query = mysqli_query($conn, $sql);
 $data = '';
 
 while ($row = mysqli_fetch_assoc($query)) {
    $status = $row['details']  == "" ? 'X' : '✓';
    $data .= "<tr class='bg-gray-100'>
        <td class='border-r text-l py-2 px-4'>" . $row['id'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $row['date'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $row['cname'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $row['cnohp'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $row['category'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $row['type'] . "</td>
        <td class='border-r text-l py-2 px-4'>" . $status . "</td>";
        

    if ($_SESSION['type'] === 'admin') {
        $data .= "<td class='border-r text-l py-2 px-2'>
          <a href='bliss-infocomplaint.php?id=" . $row['id'] . "'><button class='rounded-md bg-blue-700 text-white p-2 m-2' type='button' name='info'>Info</button></a>
          <a href='bliss-deletecomplaint.php?id=" . $row['id'] . "'><button class='rounded-md bg-red-700 text-white p-2 m-2' type='button' name='delete'>Delete</button></a>
        </td>";
    }

    $data .= "</tr>";
}
 ?>
</head>

<body>
<?php
    if (mysqli_num_rows($query) > 0) {
    ?>
    <table class="w-full text-centerw-full text-center text-grey-500 dark:text-gray-400">
        <thead class="text-black uppercase bg-white dark:bg-gray-700 dark:text-black">
            <tr class="border-b bg-gray-700">
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">ID</th>
                <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">DATE/TIME</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">CUSTOMER NAME</th>
                <th scope="col" class="text-md font-medium text-white px-8 py-2 border-r">CUSTOMER NO.HP</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">CATEGORY</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">TYPE</th>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">STATUS</th>
                <?php if ($_SESSION['type'] === 'admin') { ?>
                <th scope="col" class="text-md font-medium text-white px-4 py-2 border-r">ACTION</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="showdata" class="bg-white text-black">
            <?php echo $data; ?>
        </tbody>
    </table>
    <?php
    } else {
        echo "<h1 class='text-center text-danger mt-5'>No data found</h1>";
    }
    ?>
    </div>
</body>

</html>