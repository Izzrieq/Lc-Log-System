<?php
include "../DB/config.php"; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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

        // Function to show/hide rows based on the selected "Type"
        function toggleRows(selectedType) {
            if (selectedType == 1) {
                // If "Semua Lcid, Semua Bulan" is selected, hide LC ID and Month fields, show Pilihan row
                $("#lcid_row, #bulan_row").hide();
                $("#pilihan_row").show();
            } else if (selectedType == 2) {
                // If "Mengikut Lcid" is selected, hide Pilihan and Month fields, show LC ID row
                $("#bulan_row").hide();
                $("#lcid_row").show();
                $("#pilihan_row").prop('disabled', false); //Enable the Pilihan select
            } else if (selectedType == 3) {
                // If "Mengikut Bulan" is selected, hide Pilihan and LC ID fields, show Month row
                $("#lcid_row").hide();
                $("#bulan_row").show();
                $("#pilihan_row").prop('disabled', false); //Enable the Pilihan select
            } else if (selectedType == 4) {
                // If "Mengikut Lcid dan Bulan" is selected, show LC ID and Month fields, hide Pilihan row
                $("#lcid_row, #bulan_row").show();
                $("#pilihan_row").prop('disabled', false); //Enable the Pilihan select
            }
        }

        // Toggle rows based on the selected "Type" when the page loads
        toggleRows($("#pilihan").val());

        // Toggle rows based on the selected "Type" when the user changes the selection
        $("#pilihan").on("change", function () {
            var selectedType = $(this).val();
            toggleRows(selectedType);
        });
    });
</script>

<body>
    <header class="d-flex justify-content-between bg-white p-3">
        <div class="logo" style="width: 350px; height: auto; padding: 0px;">
            <a href="../../home.php">
                <img class="w-100 h-100" src="../img/LC_COMPANY LOGO_MARCH 2023-01.png" alt="logo">
            </a>
        </div>
    </header>
    <center>
        <div>
            <button class="rounded-md bg-blue-700 text-white px-3 py-2 m-2" type="back" onclick="history.back()">BACK <i
                    class="fa fa-undo" aria-hidden="true"></i>
            </button>
        </div>
        <form class="mt-2" action="print-selection.php" method="post">

            <table class="border border-gray-700 w-fit sm:px-6 lg:px-8">
                <thead class="border-b border-gray-700">
                    <tr class="font-bold text-lg text-black">
                        <th scope="col" class="text-gray-900 px-6 py-4 text-center">REPORT COMPLAINT</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr id="pilihan_row">
                        <td class="px-3 py-4">
                            <label for="pilihan" class="block uppercase text-blueGray-600 text-lg font-bold mb-0">BY
                                <select name="pilihan" id="pilihan"
                                    class="px-4 py-2 ml-4 text-blueGray-600 bg-white rounded font-medium text-medium text-lg shadow focus:outline-none focus:ring w-fit ease-linear transition-all duration-150">
                                    <option value="" selected disabled>Choose Your Report</option>
                                    <option value=1>ALL LC ID/MONTH</option>
                                    <option value=2>By LC ID</option>
                                    <option value=3>By MONTH</option>
                                    <option value=4>By LC ID & MONTH</option>
                                </select>
                            </label>
                        </td>
                    </tr>
                    <tr id="lcid_row">
                        <td class="px-3 py-4">
                            <label class="block uppercase text-blueGray-600 text-lg font-bold mb-0" for="lcid">
                                LC ID
                                <input type="text" name="lcid" id="lcid"
                                    class="border-0 px-3 py-2 ml-4 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-medium font-medium text-lg shadow focus:outline-none focus:ring w-3/4 ease-linear transition-all duration-150"
                                    placeholder="Enter LC ID">
                            </label>
                        </td>
                    </tr>
                    <tr id="bulan_row">
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
                        <td>
                            <button
                                class="bg-blue-500 w-full text-white active:bg-pink-600 font-bold text-md uppercase px-4 py-1 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                style="background-image: url(image/printer-icon.png);" type="submit">SUBMIT</button>
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