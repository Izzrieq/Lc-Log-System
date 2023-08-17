<?php
    include "../DB/config.php"; 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <center>
        <div class="relative overflow-x-auto">
            <form action="print-report.php" method="post">
                <table class="w-full text-left text-black">
                        <tr class="text-black uppercase bg-gray-700 border-b">
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">LCID</th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">CATEGORY COMPLAINT :</th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">TYPE COMPLAIN</th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">MONTH</th>
                            <th scope="col" class="text-md font-medium text-white px-2 py-2 border-r">TYPE OF REPORT</th>
                        </tr>
                    </thead>
                    <tr>
                        <td><select name="lcid">
                                <?php
                    //masukkan nama homestay dari jadual
                    $sql = "SELECT * FROM complaintbliss";
                    $data = mysqli_query($conn, $sql);
                    while ($lcid = mysqli_fetch_array($data)) {
                      echo "<option value='$lcid[lcid]'>$lcid[lcid]</option>";
                    }
                ?>
                            </select>
                        <td><select name="category">
                                <?php
                    //masukkan category dari jadual complaint bliss
                    $sql = "SELECT * FROM complaintbliss";
                    $data = mysqli_query($conn, $sql);
                    while ($category = mysqli_fetch_array($data)) {
                      echo "<option value='$category[category]'>$category[category]</option>";
                    }
                ?>
                        <td><select name="type">
                                <?php
                    //masukkan type dari jadual complaint bliss
                    $sql = "SELECT * FROM complaintbliss";
                    $data = mysqli_query($conn, $sql);
                    while ($type = mysqli_fetch_array($data)) {
                      echo "<option value='$type[type]'>$type[type]</option>";
                    }
                ?>
                            </select>
                        <td><select name="month">
                                <?php
                        //masukkan nama bulan dalam pilihan
                        $month = array("January", "February", "March", "April", "May", "June",
                                      "July", "August","September","October", "November", "Dicember");
                        for($i = 0; $i < 12; $i++ ) {
                            $b = $i + 1;
                            echo "<option value = $b> $month[$i] </option>";
                        }
                    ?>
                            </select>
                        </td>
                        <td><select name="choice">
                                <option value=1>Yearly</option>
                                <option value=2>According to LC ID</option>
                                <option value=3>Monthly</option>
                                <option value=4>LC ID/Monthly</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <button type="submit">Papar</button>
            </form>
        </div>
    </center>
</body>

</html>