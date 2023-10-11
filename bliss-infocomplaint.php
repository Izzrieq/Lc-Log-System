<?php
include("COMPONENT/DB/config.php");
$isPrinting = isset($_GET['print']) && $_GET['print'] === 'true';
if (!$isPrinting) {
    include "COMPONENT/header.php";
}

// Make sure there's an active session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the update here
    $updated_cname = mysqli_real_escape_string($conn, $_POST['updated_cname']);
    $updated_cnohp = mysqli_real_escape_string($conn, $_POST['updated_cnohp']);
    $updated_caller = mysqli_real_escape_string($conn, $_POST['updated_caller']);
    $updated_channel = mysqli_real_escape_string($conn, $_POST['updated_channel']);
    $updated_category = mysqli_real_escape_string($conn, $_POST['updated_category']);
    $updated_type = mysqli_real_escape_string($conn, $_POST['updated_type']);
    $updated_details = mysqli_real_escape_string($conn, $_POST['updated_details']);
    $updated_principal = mysqli_real_escape_string($conn, $_POST['updated_principal']);
    $updated_ownernohp = mysqli_real_escape_string($conn, $_POST['updated_ownernohp']);

    $update_sql = "UPDATE complaintbliss SET cname='$updated_cname',cnohp='$updated_cnohp', caller='$updated_caller', channel='$updated_channel', category='$updated_category', type='$updated_type', details='$updated_details', principal='$updated_principal', ownernohp='$updated_ownernohp' WHERE id='$id'";

    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        echo "<script>alert('Complaint updated successfully.');</script>";
    } else {
        echo "<script>alert('Failed to update complaint.');</script>";
    }
}

$data = mysqli_query($conn, "SELECT * FROM complaintbliss WHERE id='$id'");
while ($r = mysqli_fetch_array($data)) {
    $id = $r['id'];
    $date = $r['date'];
    $cname = $r['cname'];
    $cnohp = $r['cnohp'];
    $caller = $r['caller'];
    $channel = $r['channel'];
    $category = $r['category'];
    $type = $r['type'];
    $details = $r['details'];
    $lcid = $r['lcid'];
    $principal = $r['principal'];
    $ownernohp = $r['ownernohp'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint INFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
        @media print {
            /* Add CSS rules to hide the header when printing */
            header {
                display: none;
            }
        }
    </style>

<body>
    

<div class="container-box" style="display: flex; justify-content:center;">
    <div class="bg-gray-200 min-h-screen pt-0 my-0">
        <div class="container mx-auto">
            <div class="inputs w-full max-w-xl p-6">
                <div class='flex items-center justify-between mt-2'>
                    <div class="personal w-full pt-2">
                        <h2 class="text-2xl text-gray-900"><?php
                                            if($lcid == "" || $lcid == "-"){
                                            echo "N/A";
                                           }else{
                                            echo $lcid;
                                           } ?></h2>
                        <form method="POST" action="">
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ID
                                    </label>
                                    <input name="id" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php echo $id; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date
                                        Complaint
                                    </label>
                                    <input name="date" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php echo $date; ?>" disabled />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer
                                        Complaint Name </label>
                                    <input name="updated_cname" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php echo $cname; ?>" />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer
                                        NO.HP
                                    </label>
                                    <input name="updated_cnohp" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php echo $cnohp; ?>" />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Caller </label>
                                           <select name="updated_caller" id="text"
                                                 class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <option value="Parents" <?php if ($caller === "Parents") echo "selected"; ?>>Parents</option>
                                            <option value="Operator" <?php if ($caller === "Operator") echo "selected"; ?>>Operator</option>
                                            <option value="Public" <?php if ($caller === "Public") echo "selected"; ?>>Public</option>
                                            <option value="Sales" <?php if ($caller === "Sales") echo "selected"; ?>>Sales</option>
                                            <option value="Others" <?php if ($caller === "Others") echo "selected"; ?>>Others</option>
                                        </select>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Channel
                                    </label>
                                    <select name="updated_channel" id="text"
                                                 class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                            <option value="Office" <?php if ($channel === "Office") echo "selected"; ?>>Office</option>
                                            <option value="Whatsapp" <?php if ($channel === "Whatsapp") echo "selected"; ?>>Whatsapp</option>
                                            <option value="Telegram" <?php if ($channel === "Telegram") echo "selected"; ?>>Telegram</option>
                                            <option value="Email" <?php if ($channel === "Email") echo "selected"; ?>>Email</option>
                                            <option value="Others" <?php if ($channel === "Others") echo "selected"; ?>>Others</option>
                                        </select>
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Category</label>
                                <select name="updated_category" id="text"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    <option value="Complaint" <?php if ($category === "Complaint") echo "selected"; ?>>Complaint</option>
                                    <option value="Suggestion" <?php if ($category === "Suggestion") echo "selected"; ?>>Suggestion</option>
                                    <option value="General" <?php if ($category === "General") echo "selected"; ?>>General</option>
                                    <option value="Enquiry" <?php if ($category === "Enquiry") echo "selected"; ?>>Enquiry</option>
                                    <option value="Others" <?php if ($channel === "Others") echo "selected"; ?>>Others</option>
                                </select>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type</label>
                                <select name="updated_type" id="text"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                    <option value="Management" <?php if ($type === "Management") echo "selected"; ?>>Management</option>
                                    <option value="Sales" <?php if ($type === "Sales") echo "selected"; ?>>Sales</option>
                                    <option value="Registration" <?php if ($type === "Registration") echo "selected"; ?>>Registration</option>
                                    <option value="Payment" <?php if ($type === "Payment") echo "selected"; ?>>Payment</option>
                                    <option value="Kindy" <?php if ($type === "Kindy") echo "selected"; ?>>Kindy</option>
                                    <option value="Email" <?php if ($type === "Email") echo "selected"; ?>>Email</option>
                                    <option value="Job Vacancy" <?php if ($type === "Job Vacancy") echo "selected"; ?>>Job Vacancy</option>
                                    <option value="Others" <?php if ($type === "Others") echo "selected"; ?>>Others</option>
                                </select>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Details</label>
                                <textarea name="updated_details" type="text"
                                          class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'><?php echo $details; ?></textarea>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Lc
                                        Owner
                                    </label>
                                    <input name="updated_principal" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php
                                           if($principal == ""){
                                            echo "N/A";
                                           }else{
                                            echo $principal;
                                           } ?>" />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner
                                        No.Hp
                                    </label>
                                    <input name="updated_ownernohp" type="text"
                                           class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                           value="<?php 
                                           if($ownernohp == ""){
                                            echo "N/A";
                                           }else{
                                            echo $ownernohp;
                                           }
                                           ?>" />
                                </div>
                            </div>
                            </form> 
                            <div class="flex justify-center">
                                    <button class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                        type="back" onclick="goBack()">BACK <i class="fa fa-undo" aria-hidden="true"></i></button>
                                    <button class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900"
                                        type="submit" onclick="submitForm()">UPDATE <i class="fa fa-update" aria-hidden="true"></i></button>
                                    <button id="print"
                                        class="text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900"
                                        onclick="goPrint()">PRINT</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function goBack() {
        window.location.href = 'bliss-operator.php';
    }

    function goPrint() {
        // Print the document
        window.print();
    }
    function submitForm() {
        // Get the form element by its ID
        const form = document.querySelector('form'); // Replace 'form' with the actual ID of your form element

        // Submit the form
        if (form) {
            form.submit();
        }
    }
</script>

</body>

</html>
