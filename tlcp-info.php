<?php
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";



$branch_id = $_GET['branch_id'];

$operator_first_name = '';

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

// Fetch data from the 'user_operator' table
// $data3 = mysqli_query($conn, "SELECT * FROM user_operator WHERE branch_id='$branch_id'");
// while ($o = mysqli_fetch_array($data3)) {
//     $operator_first_name = $o['first_name'];
//     $last_name = $o['last_name'];
//     $ic = $o['ic'];
//     $email = $o['email'];
//     $mobile_no = $o['mobile'];
//     $edu = $o['edu'];
//     $employer = $o['employer'];
//     $role_id = $o['type'];
//     $occupation = $o['occupation'];
//     $office_address = $o['office_address'];

// }

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

<body class="bg-neutral-50">
    <!-- component -->
    <!-- component -->
    <div class="container-box pb-20 " style="display: flex; justify-content:center;">
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
                                            echo "ACTIVE";
                                        }else{
                                            echo "UNAVAILABLE";
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
                            <div class="flex items-center justify-between mt-0">
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
        <div class="container-box pb-20" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto border-2">
                    <div class="inputs w-full y-full max-w-xl p-6">
                        <!-- <div class='flex items-center justify-between mt-2'> -->
                        <div class="personal w-full md:w-full pt-2">
                        <h6 class="text-blueGray-400 text-l mt-3 mb-4 font-bold uppercase">
                            OPERATOR Information
                        </h6>
                        <hr class="mt-6 border-b-1 border-blueGray-300">    
                            <div class='w-full md:w-full px-3'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OPERATOR NAME
                                </label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    type='text' name="first_name" value="" disabled/>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6 pt-4'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>LAST NAME</label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='last_name' name="last_name" value="" disabled/>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-auto md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>YEAR SIGNED</label>
                                    <input
                                        class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='yearsigned' name="yearsigned" value="" disabled/>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>EMAIL</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='eduemail' name="eduemail" value="" disabled/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-full px-3 mb-4'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OFFICE ADDRESS</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='operator_address' name="operator_address" value="" disabled/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TYPE</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='type' name="type" value="" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OWNER NOHP
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='ownernohp' name="ownernohp" value="" disabled />
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATUS
                                </label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='status' name="status" value="" disabled />
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TLCP PACKAGE
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='tlcppackage' name="tlcppackage" value="" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ANNUAL LICENSE</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3'
                                        type='annuallicense' name="annuallicense" value="" disabled />
                                </div>
                            </div>
                            <div class='w-auto md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>KINDER ADDRESS</label>
                                <textarea name="operatoraddress"
                                    class='bg-white rounded-md border leading-normal resize-none w-full h-50 py-2 px-3 shadow-inner border border-gray-400 placeholder-gray-700 focus:outline-none focus:bg-white' disabled></textarea>
                            </div>
                            <div class="flex justify-end">
                              <button class="rounded-md bg-blue-700 text-white px-3 py-2 m-2"
                                    type="back" onclick="history.back()">BACK <i class="fa fa-undo" aria-hidden="true"></i></button>
                                <button
                                    class="rounded-md border-2 border-gray-500 bg-gray-200 text-gray-900 px-3 py-2 m-2"
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