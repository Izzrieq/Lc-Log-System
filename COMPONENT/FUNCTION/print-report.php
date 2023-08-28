<?php
    include "../DB/config.php"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<form action="print-selection.php" method="post">
        <table>
            <tr>
                <th>Lcid</th>
                <th>Date</th>
                <th>Type</th>
            </tr>
            <tr>
                <td><select name="lcid">
                <?php
                    //masukkan nama homestay dari jadual
                    $sql = "select * from lcdetails";
                    $data = mysqli_query($conn, $sql);
                    while ($lcid = mysqli_fetch_array($data)) {
                      echo "<option value='$lcid[lcid]'>$lcid[lcid]</option>";
                    }
                ?> 
                </select>
                <td><select name="bulan">
                    <?php
                        //masukkan nama bulan dalam pilihan
                        $bulan = array("January", "February", "March", "April", "Mai", "June",
                                      "July", "August","September","October", "November", "December");
                        for($i = 0; $i < 12; $i++ ) {
                            $b = $i + 1;
                            echo "<option value = $b> $bulan[$i] </option>";
                        }
                    ?> 
                </select>
                </td>
                <td><select name="pilihan">
                    <option value=1>Semua Lcid, Semua Bulan</option>
                    <option value=2>Mengikut Lcid</option>
                    <option value=3>Mengikut Bulan</option>
                    <option value=4>Mengikut Lcid dan Bulan</option>
                    </select>
                </td>    
            </tr>
        </table>
        <button style="background-image: url(image/printer-icon.png);" type="submit">Papar</button>
    </form>
</body>

</html> 