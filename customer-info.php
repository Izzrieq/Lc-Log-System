<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }

$parent_id = $_GET['parent_id'];
$data = mysqli_query($conn, "SELECT * FROM student WHERE parent_id='$parent_id'");
 while ($r = mysqli_fetch_array($data)){
    $student_id = $r['student_id'];
    $name = $r['name'];
    $gender = $r['gender'];
    $birth_date = $r['birth_date'];
    $birth_place = $r['birth_place'];
    $ic = $r['ic'];
    $birth_cert_no = $r['birth_cert_no'];
    $fav_food = $r['fav_food'];
    $parent_id = $r['parent_id'];
    $status = $r['status'];
    $prev_school = $r['prev_school'];
    $race = $r['race'];
    $religion = $r['religion'];
    $illness = $r['illness'];
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER INFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
    @media print {
        button {
            display: none;
        }
    }
</style>

<body class="bg-neutral-50">
    <div class="container-box pb-0 " style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 my-0">
            <div class="container mx-auto border-2">
                <div class="inputs w-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900 text-xl font-bold">CUSTOMER INFO</h2>
                            <hr class="mt-1 border-b-1 border-blueGray-300">
                            <h6 class="text-blueGray-400 text-sm font-bold mt-3 mb-4 uppercase">
                                Student Information
                            </h6>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STUDENT
                                        ID
                                    </label>
                                    <input name="student_id" type="student_id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php 
                                        if ($student_id == ""){
                                            echo "N/A";
                                        }else{
                                            echo $student_id;
                                        } ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH
                                        DATE
                                    </label>
                                    <input name="name" type="name"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php 
                                        if ($birth_date == ""){
                                            echo "N/A";
                                        }else{
                                            echo $birth_date;
                                        } 
                                        ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>GENDER
                                    </label>
                                    <input name="gender" type='gender'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php 
                                        if ($gender == '1'){
                                            echo 'MALE';
                                        }else{
                                            echo 'FEMALE';
                                        }
                                        ?> disabled>
                                </div>
                            </div>
                            <!-- <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Little
                                    Caliphs ID
                                </label>
                                <input name="lcid" type="text"
                                    class="appearance-none block w-1/2 bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4"
                                    value="<?php echo htmlspecialchars($lcid); ?>" disabled>
                            </div> -->
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>NAME
                                </label>
                                <input name="birth_date" type="text"
                                    class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4"
                                    value="<?php
                                    if ($name == ""){
                                        echo "N/A";
                                    }else{
                                        echo $name;
                                    }  ?>" disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH
                                    PLACE</label>
                                <input name="birth_place" type="birth_place"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php
                                         if ($birth_place == ""){
                                            echo "N/A";
                                        }else{
                                            echo $birth_place;
                                        }  ?>" disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6' style="page-break-before: always">
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>IC</label>
                                <input name="ic" type="ic"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php
                                    if ($ic == ""){
                                        echo "N/A";
                                    }else{
                                        echo $ic;
                                    }  ?>" disabled>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>FAVOURITE
                                        FOOD
                                    </label>
                                    <input name="fav_food" type="fav_food"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php 
                                        if ($fav_food == ""){
                                            echo "N/A";
                                        }else{
                                            echo $fav_food;
                                        } 
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH
                                        CERTIFICATION
                                    </label>
                                    <input name="birth_cert_no" type='birth_cert_no'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php
                                        if ($birth_cert_no == ""){
                                            echo "N/A";
                                        }else{
                                            echo $birth_cert_no;
                                        } 
                                        ?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STATUS
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="status" value="<?php 
                                        if ($status == '1'){
                                            echo 'ACTIVE';
                                        }else{
                                            echo 'UNACTIVE';
                                        }
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>PREVIOUS
                                        SCHOOL
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="prev_school" value="<?php
                                        if ($prev_school == ""|| $prev_school == "None"){
                                            echo "N/A";
                                        }else{
                                            echo $prev_school;
                                        } 
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>RACE
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="race" value="<?php  
                                        if ($race == '1'){
                                            echo 'MALAY';
                                        }else if($race == '2'){
                                            echo 'INDIAN';
                                        }else if($race == '3'){
                                            echo 'CHINESE';
                                        }else if($race == '0'){
                                            echo 'OTHERS';
                                        }?>" disabled>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>RELIGION
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="religion" value="<?php 
                                        if($religion == '1'){
                                            echo 'ISLAM';
                                        }else{
                                            echo 'Others';
                                        }
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ILLNESS
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="illness" value="<?php 
                                        if ($illness == "" || $illness == "None"){
                                            echo "N/A";
                                        }else{
                                            echo "$illness";
                                        } 
                                        ?>" disabled>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
            $parent_id = $_GET['parent_id'];
            $data = mysqli_query($conn, "SELECT * FROM emergency_contact WHERE parent_id='$parent_id'");
            while ($r = mysqli_fetch_array($data)){
            $first_name = $r['first_name'];
            $last_name = $r['last_name'];
            $relation = $r['relation'];
            $mobile_no = $r['mobile_no'];
            $home_no = $r['home_no'];
            $office_no = $r['office_no'];
            $email = $r['email'];
            $ic = $r['ic'];
            //  $lc = $r['lc'];
            }
            $spouse = mysqli_query($conn, "SELECT * FROM spouse WHERE parent_id='$parent_id'");
            while ($s = mysqli_fetch_array($spouse)){
                $spousefirst_name = $s['first_name'];
                $spouselast_name = $s['last_name'];
                $spouseic =$s['ic'];
                $spousemobile_no = $s['mobile_no'];
                $spouserelation = $s['relation'];
                $address = $s['address'];
            }
            ?>
        <div class="container-box pb-0" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto border-2">
                    <div class="inputs w-full y-full max-w-xl p-6">
                        <div class='flex items-center justify-between mt-2'>
                            <div class="personal w-full md:w-full pt-2">
                                <h6 class="text-blueGray-400 text-sm font-bold mt-0 mb-4 uppercase">
                                    Parent Information
                                </h6>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-auto md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>FIRST
                                            NAME</label>
                                        <input
                                            class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='text' name="first_name" value="<?php
                                             if ($first_name == ""){
                                            echo "N/A";
                                            }else{
                                            echo $first_name;
                                            }  ?>" disabled />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>LAST
                                            NAME</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                            type='text' name="last_name" value="<?php 
                                            if ($last_name == ""){
                                                echo "N/A";
                                                }else{
                                                echo $last_name;
                                                } 
                                            ?>" disabled />
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <div class='w-auto md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>RELATION</label>
                                        <input
                                            class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='relation' name="relation" value="<?php 
                                            if ($relation == ""){
                                                echo "N/A";
                                                }else{
                                                echo $relation;
                                                } 
                                            ?>" disabled />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>MOBILE
                                            NO</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                            type='mobile_no' name="mobile_no" value="<?php 
                                            if ($mobile_no == ""){
                                                echo "N/A";
                                                }else{
                                                echo  $mobile_no;
                                                } 
                                            ?>"
                                            disabled />
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <div class='w-auto md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>SPOUSE
                                            FIRST NAME</label>
                                        <input
                                            class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='text' name="spousefirst_name" value="<?php 
                                            if ($spousefirst_name == ""){
                                                echo "N/A";
                                                }else{
                                                echo $spousefirst_name;
                                                } 
                                            ?>"
                                            disabled />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>SPOUSE
                                            LAST NAME</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                            type='text' name="spouselast_name" value="<?php 
                                            if ($spouselast_name == ""){
                                                echo "N/A";
                                                }else{
                                                echo $spouselast_name;
                                                } 
                                            ?>"
                                            disabled />
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-1" style="page-break-before: always">
                                    <div class='w-auto md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>RELATION</label>
                                        <input
                                            class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='relation' name="spouserelation" value="<?php 
                                            if ($spouserelation == ""){
                                                echo "N/A";
                                                }else{
                                                echo $spouserelation;
                                                } 
                                            ?>"
                                            disabled />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>MOBILE
                                            NO</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                            type='mobile_no' name="spousemobile_no"
                                            value="<?php
                                            if ($spousemobile_no == ""){
                                                echo "N/A";
                                                }else{
                                                echo $spousemobile_no;
                                                } 
                                            ?>" disabled />
                                    </div>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6 mt-0'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ADDRESS
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="address" value="<?php 
                                        if ($address == ""){
                                            echo "N/A";
                                            }else{
                                            echo $address;
                                            }  ?>" disabled />
                                </div>
                                <hr class="mt-1 border-b-1 border-blueGray-300">
                                <h6 class="text-blueGray-400 text-sm font-bold mt-3 mb-3 uppercase">
                                    Emergency Contact
                                </h6>
                                <div class="flex items-center justify-between mt-0">
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>HOME
                                            NO
                                        </label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='text' name="home_no" value="<?php 
                                            if ($home_no == "" || $home_no == "None"){
                                                echo "N/A";
                                                }else{
                                                echo $home_no;
                                                } 
                                            ?>" disabled />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>OFFICE
                                            NO</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3'
                                            type='text' name="office_no" value="<?php 
                                            if ($office_no == "" || $office_no == "None"){
                                                echo "N/A";
                                                }else{
                                                echo $office_no;
                                                } 
                                            ?>" disabled />
                                    </div>
                                </div>
                                <hr class="mt-1 border-b-1 border-blueGray-300">
                                <div class="flex items-center justify-between mt-0">
                                    <div class='w-full md:w-full px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>EMAIL
                                        </label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                            type='email' name="email" value="<?php 
                                            if ($email == ""){
                                                echo "N/A";
                                                }else{
                                                echo $email;
                                                } 
                                            ?>" disabled />
                                    </div>
                                </div>
                                <div class="flex justify-end mb-5">
                              <button class="rounded-md bg-blue-700 text-white px-3 py-2 m-2"
                                    type="back" onclick="history.back()">BACK <i class="fa fa-undo" aria-hidden="true"></i></button>
                                <button
                                    class="rounded-md border-2 border-gray-500 bg-gray-200 text-gray-900 px-3 py-2 m-2"
                                    onclick="printWithLandscape()">PRINT</button>
                            </div>
                            </div>
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