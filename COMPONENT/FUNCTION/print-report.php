<?php
    include "../DB/config.php"; 
    include_once "../header.php";
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
    <center>
        <form class="mt-2" action="print-selection.php" method="post">
            <table class="border border-gray-700 w-fit sm:px-6 lg:px-8">
                <thead class="border-b border-gray-700">
                    <tr class="font-bold text-lg text-black">
                        <th scope="col" class="text-gray-900 px-6 py-4 text-center">REPORT COMPLAINT</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td class="px-3 py-4">
                            <label class="block uppercase text-blueGray-600 text-lg font-bold mb-0" for="lcid">
                                LC ID
                                <input type="text" name="lcid" id="lcid"
                                    class="border-0 px-3 py-2 ml-4 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-medium font-medium text-lg shadow focus:outline-none focus:ring w-3/4 ease-linear transition-all duration-150"
                                    placeholder="Enter LC ID">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-4">
                            <label for="bulan" class="block uppercase text-blueGray-600 text-lg font-bold mb-0">Date
                                <select name="bulan"
                                    class="px-4 py-2 ml-4 text-blueGray-600 bg-white rounded font-medium text-medium text-lg shadow focus:outline-none focus:ring w-3/4 ease-linear transition-all duration-150">
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
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4">
                            <label for="pilihan" class="block uppercase text-blueGray-600 text-lg font-bold mb-0">Type
                                <select name="pilihan"
                                    class="px-4 py-2 ml-4 text-blueGray-600 bg-white rounded font-medium text-medium text-lg shadow focus:outline-none focus:ring w-fit ease-linear transition-all duration-150">
                                    <option value=1>Semua Lcid, Semua Bulan</option>
                                    <option value=2>Mengikut Lcid</option>
                                    <option value=3>Mengikut Bulan</option>
                                    <option value=4>Mengikut Lcid dan Bulan</option>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="bg-blue-500 w-full text-white active:bg-pink-600 font-bold text-lg uppercase px-4 py-1 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                style="background-image: url(image/printer-icon.png);" type="submit">Papar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </center>
</body>

</html>
<?php
include "../footer.php";
?>
