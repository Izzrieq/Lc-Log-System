<?php
include("COMPONENT/DB/config.php");
include "COMPONENT/header.php";
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }


$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM complaintbliss WHERE id='$id'");
while ($r = mysqli_fetch_array($data)) {
    $id = $r['id'];
    $date = $r['date'];
    $cname = $r['cname'];
    $cnohp= $r['cnohp'];
    $category = $r['category'];
    $type = $r['type'];
    $details = $r['details'];
    $lcid = $r['lcid'];
    $lcowner = $r['lcowner'];
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

<body>

        <div class="container-box" style="display: flex; justify-content:center;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto">
                    <div class="inputs w-full max-w-xl p-6">
                        <div class='flex items-center justify-between mt-2'>
                            <div class="personal w-full pt-2">
                                <h2 class="text-2xl text-gray-900"><?php echo $lcid ?></h2>
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
                                    <!-- <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Cus
                                    </label>
                                    <input name="bizstype" type='text'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                         value=<?php echo $cname; ?> />
                                </div> -->
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer
                                        Complaint Name </label>
                                    <input name="cname" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value="<?php echo $cname; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer
                                        NO.HP
                                    </label>
                                    <input name="cnohp" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value="<?php echo $cnohp; ?>" disabled />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Category</label>
                                    <select name="category" id="text"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        disabled>
                                        <option value="<?php echo $category; ?>" disabled></option>
                                        <option value="Complaint">Complaint</option>
                                        <option value="Suggestion">Suggestion</option>
                                        <option value="General">General</option>
                                        <option value="Enquiry">Enquiry</option>
                                    </select>

                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type</label>
                                    <select name="type" id="text"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        disabled>
                                        <option value="<?php echo $type; ?>" disabled></option>
                                        <option value="Management">Management</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Registration">Registration</option>
                                        <option value="Payment">Payment</option>
                                        <option value="Kindy">Kindy</option>
                                    </select>

                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Details</label>
                                    <textarea name="details" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        disabled><?php echo $details; ?></textarea>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class='w-full md:w-full px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Lc
                                            Owner
                                        </label>
                                        <input name="lcowner" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none  focus:border-gray-500'
                                            value="<?php echo htmlspecialchars($lcowner); ?>" disabled />
                                    </div>
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner
                                        No.Hp
                                    </label>
                                    <input name="ownernohp" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value="<?php echo $ownernohp; ?>" disabled />
                                </div>
                                <div class="flex justify-end">
                                    <button class="rounded-md bg-blue-700 text-white px-3 py-2 m-2" type="back"
                                        onclick="history.back()">BACK <i class="fa fa-undo" aria-hidden="true"></i></button>
                                    <button
                                        class="rounded-md border-2 border-gray-500 bg-gray-200 text-gray-900 p-2 m-2"
                                        onclick="window.print()">Print</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>