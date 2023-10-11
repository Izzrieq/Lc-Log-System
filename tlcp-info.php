<?php
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";



$branch_id = $_GET['branch_id'];



$data1 = mysqli_query($conn, "SELECT * FROM branch WHERE branch_id='$branch_id'");
while ($r = mysqli_fetch_array($data1)) {
    $branch_id = $r['branch_id'];
    $code = $r['code'];
    $name = $r['name'];
    $email_regis = $r['email_regis'];
    $address = $r['address'];
    $date_register = $r['date_register'];
    $is_active = $r['is_active'];
    $bill_due = $r['bill_due'];
}

// $first_name = '';
// $last_name = '';
// $email = '';
// $ic = '';
// $mobile_no = '';
// $role_id = '';
// $status_teacher = '';
// $edu = '';
// $state_id = '';

// $state_name = '';

// $cities_name = '';

// Fetch data from the 'user_teacher' table
$data2 = mysqli_query($conn, "SELECT * FROM user_teacher WHERE branch_id='$branch_id'");
while ($t = mysqli_fetch_array($data2)) {
    $first_name = $t['first_name'];
    $last_name = $t['last_name'];
    $email = $t['email'];
    $ic = $t['ic'];
    $mobile_no = $t['mobile_no'];
    $role_id = $t['role_id'];
    $status_teacher = $t['status'];
    $edu = $t['edu'];
    $state_id = $t['state_id'];
    // Fetch the state name from the 'states' table based on state_id
    $state_query = mysqli_query($conn, "SELECT name FROM states WHERE id='$state_id'");
    $state_data = mysqli_fetch_array($state_query);
    $state_name = $state_data['name'];

    $city_id = $t['city_id'];
    $cities_query = mysqli_query($conn, "SELECT name FROM cities WHERE id='$city_id'");
    $cities_data = mysqli_fetch_array($cities_query);
    $cities_name = $cities_data['name'];

}

// $stateid = '';
// $bizstype = ''; 
// $lcid = ''; 
   $operatorname = '';
// $ownername = ''; 
// $yearsigned = '';
// $datesigned = ''; 
// $dateoperated = '';
// $tlcppackage = '';
// $annuallicense = ''; 
// $eduemail = '';
// $kindername = ''; 
// $kindernohp = ''; 
// $type = ''; 
// $ownernohp = '';
//Fetch data from the 'user_operator' table
$data3 = mysqli_query($conn, "SELECT * FROM branchdetails WHERE branch_id='$branch_id'");
if (!$data3) {
    die("Query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($data3) > 0) {
    $o = mysqli_fetch_array($data3);
    $operatorname = $o['operatorname'];
// Debugging
// /var_dump($operatorname); // Print the value of $operatorname for debugging purposes

    $stateid = $o['stateid'];
    $bizstype = $o['bizstype'];
    $lcid = $o['lcid'];
    $operatorname = $o['operatorname'];
    $ownername = $o['ownername'];
    $yearsigned = $o['yearsigned'];
    $datesigned = $o['datesigned'];
    $dateoperated = $o['dateoperated'];
    $tlcppackage = $o['tlcppackage'];
    $annuallicense = $o['annuallicense'];
    $eduemail = $o['eduemail'];
    $kindername = $o['kindername'];
    $kindernohp = $o['kindernohp'];
    $type = $o['type'];
    $ownernohp = $o['ownernohp'];
    // Continue fetching other variables here
} else {
    echo "No data found for branch_id: $branch_id";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
    @media print{
        button{
            display: none;
        }
    }
</style>

<body class="bg-neutral-50 mb-5">
    <!-- component -->
    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 my-0">
            <div class="container mx-auto border-2">
                <div class="inputs w-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900 text-lg">TLCP INFO: <?php echo $code; ?></h2>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BRANCH ID
                                    </label>
                                    <input name="branch_id" type="branch_id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $branch_id; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>DATE REGISTER
                                    </label>
                                    <input name="date_register" type="date_register"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $date_register; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATUS
                                    </label>
                                    <input name="is_active" type='is_active'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php
                                        if($is_active == '1'){
                                            echo "ACTIVE";
                                        }else{
                                            echo "UNAVAILABLE";
                                        }
                                        ?> disabled>
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ADDRESS
                                </label>
                                    <textarea name="address"
                                    class='bg-white rounded-md border leading-normal resize-none w-full h-20 py-2 px-3 shadow-inner border border-gray-400 placeholder-gray-700 focus:outline-none focus:bg-white' disabled><?php echo $address; ?></textarea>

                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BILL DUE</label>
                                <input name="bill_due" type="bill_due"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $bill_due; ?>" disabled>
                            </div>
                            <hr class="mt-6 border-b-1 border-blueGray-300">
                        <h6 class="text-blueGray-400 text-l mt-3 mb-4 font-bold uppercase">
                            Principal Information
                        </h6>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>FIRST NAME</label>
                                <input name="first_name" type="first_name"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $first_name; ?>" disabled>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>IC
                                    </label>
                                    <input name="ic" type="ic"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $ic; ?>" disabled>
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>MOBILE NO
                                    </label>
                                    <input name="mobile_no" type='mobile_no'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $mobile_no; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ROLE
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="role_id" value="<?php echo $role_id; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATUS
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="status" value="<?php 
                                        if($status_teacher == 'a'){
                                            echo "Active";
                                        }else{
                                            echo "Unavailable";
                                        }
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>EDU
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="edu" value="<?php echo $edu; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0 mb-0">
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATE
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="state_id" value="<?php echo $state_name; ?>" disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>CITY
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="city_id" value="<?php echo $cities_name; ?>" disabled>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-box" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto border-2">
                    <div class="inputs w-full y-full max-w-xl p-6">
                        <div class='flex items-center justify-between mt-0'>
                        <div class="personal w-full md:w-full pt-2">
                        <h2 class="text-2xl text-gray-900 text-lg mt-2 mb-0">
                            Operator Information
                        </h2>
                        <hr class="mt-1 border-b-1 border-blueGray-300">
                        <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATE ID
                                    </label>
                                    <input name="stateid" type="stateid"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $stateid; ?>" disabled>
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIZS TYPE
                                    </label>
                                    <input name="bizstype" type='bizstype'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $bizstype; ?>" disabled>
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OPERATOR NAME
                                </label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    type='text' name="first_name" value="<?php echo $operatorname; ?>" disabled/>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6 pt-4'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OWNER NAME</label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='last_name' name="last_name" value="<?php echo $ownername; ?>" disabled/>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>YEAR SIGNED
                                    </label>
                                    <input name="branch_id" type="branch_id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $yearsigned; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>DATE SIGNED
                                    </label>
                                    <input name="date_register" type="date_register"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $datesigned; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>DATE OPERATED
                                    </label>
                                    <input name="is_active" type='is_active'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $dateoperated; ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-full px-3 mb-4'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TLCP PACKAGE</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='operator_address' name="operator_address" value="<?php echo $tlcppackage; ?>" disabled/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ANNUAL LICENSE</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='type' name="type" value="<?php echo $annuallicense; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>EDU EMAL
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='ownernohp' name="ownernohp" value="<?php echo $eduemail; ?>" disabled />
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>KINDER NAME
                                </label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='status' name="status" value="<?php echo $kindername; ?>" disabled />
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>KINDER NOHP
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='tlcppackage' name="tlcppackage" value="<?php echo $kindername; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TYPE</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3'
                                        type='annuallicense' name="annuallicense" value="<?php echo $type; ?>" disabled />
                                </div>
                            </div>
                            <div class='w-auto md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OWNER NOHP</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3'
                                        type='annuallicense' name="annuallicense" value="<?php echo $ownernohp; ?>" disabled />
                            </div>
                            <div class="flex justify-end">
                              <button class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                    type="back" onclick="history.back()">BACK <i class="fa fa-undo" aria-hidden="true"></i></button>
                                    <button class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-900"
                                    type="submit">UPDATE <i class="fa fa-update" aria-hidden="true"></i></button>
                                <button
                                    class="text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-900"
                                    onclick="printWithLandscape()">PRINT</button>
                            </div>
                        </div>

                    </div>
                    </form>
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