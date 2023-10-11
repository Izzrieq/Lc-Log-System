<?php
     if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
    
    include "COMPONENT/header.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Add</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- tailwind -->
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">

    <!-- font -->
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
</head>
<script>
    $(document).ready(function () {
        // Initialize the jQuery UI Autocomplete on LC ID input
        $("#lcid").autocomplete({
    source: "Ajax/get_lc_suggestions.php", // URL to fetch suggestions
    minLength: 2, // Minimum characters before showing suggestions
    select: function (event, ui) {
        console.log("Selected item: " + ui.item.value);
        // When an option is selected from the autocomplete suggestions
        // Populate the input fields with data
        var selectedLcid = ui.item.value;

        if (selectedLcid !== "") {
            $.ajax({
                url: "Ajax/get_lc_data.php",
                method: "GET",
                data: {
                    code: selectedLcid
                },
                dataType: "json",
                success: function (data) {
                    console.log("Selected branch code: " + selectedLcid);
                    // Check if data.principal is defined and has a length property
                    if (data.principal && data.principal.length > 0) {
                        $("#principal").val(data.principal[0]);
                    } else {
                        $("#principal").val("");
                    }

                    // Check if data.ownerNohp is defined and has a length property
                    if (data.ownerNohp && data.ownerNohp.length > 0) {
                        $("#ownernohp").val(data.ownerNohp[0]);
                    } else {
                        $("#ownernohp").val("");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus + " - " + errorThrown);
                }
            });
        }
    }
});



        $("#cname").autocomplete({
            source: "Ajax/get_customer_suggestions.php", // URL to fetch suggestions
            minLength: 5, // Minimum characters before showing suggestions
            select: function (event, ui) {
                // When an option is selected from the autocomplete suggestions
                // Populate the input fields with data
                var selectedCustomer = ui.item.value;

                if (selectedCustomer !== "") {
                    $.ajax({
                        url: "Ajax/get_customer_data.php",
                        method: "GET",
                        data: {
                            first_name: selectedCustomer
                        },
                        dataType: "json",
                        success: function (data) {
                            // Populate the input fields with data
                            if (data.customerNohp.length > 0) {
                                $("#cnohp").val(data.customerNohp[0]);
                            } else {
                                $("#cnohp").val("");
                            }
                        }
                    });
                }
            }
        });
    });
</script>

<body class="bg-neutral-50">
    <section class=" pt-0 pb-2 bg-blueGray-50">
        <div class="w-full lg:w-8/12 px-4 mx-auto mt-4">
            <div
                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                <div class="rounded-t bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <h6 class="text-blueGray-700 text-2xl font-bold">
                            ISSUE COMPLAIN
                        </h6>
                        <button class="bg-blue-700 text-white rounded px-2"><a class="text-white no-underline" href="bliss-operator.php">Back</a> <i class="fa fa-undo"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="flex-auto px-4 lg:px-10 py-8 pt-0">
                    <form id="issueform" class="issue" action="COMPONENT/FUNCTION/add.php" method="POST">
                        <h6 class="text-blueGray-400 text-xl mt-3 mb-4 font-bold uppercase">
                            LC Details
                        </h6>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-2">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-0" for="lcid">
                                        LC ID
                                    </label>
                                    <input type="text" name="lcid" id="lcid"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        placeholder="Enter LC ID">
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-12/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2" for="principal">
                                    Principal
                                </label>
                                <input type="text" name="principal" id="principal"
                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    placeholder="-- select an option --" readonly>
                            </div>
                        </div>
                        <div class="w-full lg:w-4/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2" for="ownernohp">
                                    Telephone No
                                </label>
                                <input type="text" name="ownernohp" id="ownernohp"
                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                    placeholder="-- select an option --" readonly>
                            </div>
                        </div>
                        <hr class="mt-6 border-b-1 border-blueGray-300">
                        <h6 class="text-blueGray-400 text-xl mt-3 mb-4 font-bold uppercase">
                            Customer Information
                        </h6>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Customer Name
                                    </label>
                                    <input type="text" id="cname" name="cname" required
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Customer NO.HP
                                    </label>
                                    <input type="text" id="cnohp" name="cnohp"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        placeholder="011-2223456">
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Caller
                                    </label>
                                    <select name="caller" id="caller"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <option value="#" disabled selected>Select Caller:</option>
                                        <option value="Parents">Parents</option>
                                        <option value="Operator">Operator</option>
                                        <option value="Public">Public</option>
                                        <option value="Sales">Sales</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Channel
                                    </label>
                                    <select name="channel" id="channel"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <option value="#" disabled selected>Select Channel: </option>
                                        <option value="Office">Office</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                        <option value="Telegram">Telegram</option>
                                        <option value="Email">Email</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Category
                                    </label>
                                    <select name="category" id="category"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <option value="#" disabled selected>Select: </option>
                                        <option value="complaint">Complaint</option>
                                        <option value="suggestion">Suggestion</option>
                                        <option value="general">General</option>
                                        <option value="enquiry">Enquiry</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Type
                                    </label>
                                    <select name="type" id="type"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                        <option value="#" disabled selected>Select:</option>
                                        <option value="management">Management</option>
                                        <option value="sales">Sales</option>
                                        <option value="registration">Registration</option>
                                        <option value="payment">Payment</option>
                                        <option value="kindy">kindy</option>
                                        <option value="email">Email</option>
                                        <option value="job vacancy">Job Vacancy</option>
                                        <option value="others">Others</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-6 border-b-1 border-blueGray-300">
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Details
                                    </label>
                                    <textarea type="text" id="details" name="details"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-2">
                                    <label class="block uppercase text-blueGray-600 text-lg font-bold mb-2"
                                        htmlfor="grid-password">
                                        Action
                                    </label>
                                    <textarea type="text" id="action" name="action"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4 border-b-1 border-blueGray-300">

                        <button name="submit"
                            class="bg-pink-500 w-full text-white active:bg-pink-600 font-bold text-lg uppercase px-4 py-2.5 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                            type="submit">
                            SUBMIT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<?php include "COMPONENT/footer.php" ?>