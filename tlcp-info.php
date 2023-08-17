<?php

session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM lcdetails WHERE id='$id'");
 while ($r = mysqli_fetch_array($data)){
    $id = $r['id'];
    $stateid = $r['stateid'];
    $bizstype = $r['bizstype'];
    $lcid= $r['lcid'];
    $opsname = $r['operatorname'];
    $ownername = $r['ownername'];
    $status = $r['status'];
    $yearsigned = $r['yearsigned'];
    $datesigned = $r['datesigned'];
    $dateoperated = $r['dateoperated'];
    $tlcppackage = $r['tlcppackage'];
    $annuallicense = $r['annuallicense'];
    $eduemail = $r['eduemail'];
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body class="bg-neutral-50">
    <!-- component -->
    <!-- component -->
    <div class="container-box pb-20 " style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-fit pt-0 my-0">
            <div class="container mx-auto border-2">
                <div class="inputs w-full y-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900">TLCP INFO:</h2>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ID
                                    </label>
                                    <input name="id" type="id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $id; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>State
                                        ID
                                    </label>
                                    <input name="stateid" type="stateid"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $stateid; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Biz
                                        Type
                                    </label>
                                    <input name="bizstype" type='bizstype'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $bizstype; ?> disabled>
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Little
                                    Caliphs ID
                                </label>
                                <input name="lcid" type="text"
                                    class="appearance-none block w-1/2 bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4"
                                    value="<?php echo htmlspecialchars($lcid); ?>" disabled>

                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operator
                                    Name</label>
                                <input name="operatorname" type="operatorname"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $opsname; ?>" disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner
                                    Name</label>
                                <input name="ownername" type="ownername"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $ownername; ?>" disabled>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Status
                                    </label>
                                    <input name="status" type="status"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $status; ?>" disabled>
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Year
                                        Signed
                                    </label>
                                    <input name="yearsigned" type='yearsigned'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $yearsigned; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date
                                        Signed
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="datesigned" value="<?php echo $datesigned; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date
                                        Operated
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="stateid" value="<?php echo $dateoperated; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TLCP
                                        Package
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="bizstype" value="<?php echo $tlcppackage; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Annual
                                        License
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="annuallicense" value="<?php echo $annuallicense; ?>" disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Edu
                                        Email
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="eduemail" value="<?php echo $eduemail; ?>" disabled>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM lcdetails WHERE id='$id'");
 while ($r = mysqli_fetch_array($data)){
 $kindername = $r['kindername'];
 $kindernohp = $r['kindernohp'];
 $noblock = $r['noblock'];
 $street = $r['street'];
 $postcode = $r['postcode'];
 $city = $r['city'];
 $state = $r['state'];
 $type = $r['type'];
 $ownernohp = $r['ownernohp'];
 $opsaddress= $r['operatoraddress'];

 }
?>
        <div class="container-box pb-20" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto border-2">
                    <div class="inputs w-full y-full max-w-xl p-6">
                        <!-- <div class='flex items-center justify-between mt-2'> -->
                        <div class="personal w-full md:w-full pt-2">
                            <div class='w-full md:w-full px-3 mb-6 pt-4'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Kindergarten
                                    Name</label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='kindername' name="kindername" value="<?php echo $kindername; ?>" disabled>
                            </div>
                            <div class='w-auto md:w-1/2 px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Kindergarten
                                    Number</label>
                                <input
                                    class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='kindernohp' name="kindernohp" value="<?php echo $kindernohp; ?>" disabled>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/4 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>No.Block/House</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='noblock' name="noblock" value="<?php echo $noblock; ?>" disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6 ml-3'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Street</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='street' name="street" value="<?php echo $street; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/3 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Post
                                        Code</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='postcode' name="postcode" value="<?php echo $postcode; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>City
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='city' name="city" value="<?php echo $city; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>State
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='state' name="state" value="<?php echo $state; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='type' name="type" value="<?php echo $type; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operater
                                        Number</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='ownernohp' name="ownernohp" value="<?php echo $ownernohp; ?>" disabled>
                                </div>
                            </div>
                            <div class='w-auto md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operator
                                    Address</label>
                                <textarea name="operatoraddress"
                                    class='bg-white rounded-md border leading-normal resize-none w-full h-20 py-2 px-3 shadow-inner border border-gray-400 font-medium placeholder-gray-700 focus:outline-none focus:bg-white'
                                    disabled><?php echo $opsaddress; ?></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button class="rounded-md bg-blue-700 text-white px-3 py-2 m-2"
                                    type="back">BACK</button>
                                <button
                                    class="rounded-md border-2 border-gray-500 bg-gray-200 text-gray-900 px-3 py-2 m-2"
                                    onclick="printWithLandscape()">PRINT</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                function printWithLandscape() {
                    var css = '@page { size: landscape; }',
                        head = document.head || document.getElementsByTagName('head')[0],
                        style = document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(document.createTextNode(css));
                    }

                    head.appendChild(style);

                    window.print();
                }
            </script>
</body>

</html>
<?php include "COMPONENT/footer.php" ?>