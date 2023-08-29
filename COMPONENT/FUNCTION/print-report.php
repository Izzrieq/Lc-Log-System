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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<script>
     $(document).ready(function () {
        // Initialize the jQuery UI Autocomplete on LC ID input
        $("#lcid").autocomplete({
            source: "../../get_lc_suggestions.php", // URL to fetch suggestions
            minLength: 2, // Minimum characters before showing suggestions
        });

        // ... Rest of your code ...
    });
</script>
<body>
<form action="print-selection.php" method="post">
        <table>
            <tr>
                <th>Date</th>
                <th>Type</th>
            </tr>
            <tr>
                
                <label class="block uppercase text-blueGray-600 text-lg font-bold mb-0" for="lcid">
                                        LC ID
                                    </label>
                                    <input type="text" name="lcid" id="lcid"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        placeholder="Enter LC ID">
                <td><select name="bulan">
                    <?php
                        //masukkan nama bulan dalam pilihan
                        $bulan = array("January", "February", "March", "April", "May ", "June",
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