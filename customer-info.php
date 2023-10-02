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
                            <h2 class="text-2xl text-gray-900 text-lg">CUSTOMER INFO</h2>
                            <hr class="mt-1 border-b-1 border-blueGray-300">
                            <h6 class="text-blueGray-400 text-xs mt-3 mb-4 uppercase">
                            Student Information
                            </h6>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STUDENT ID
                                    </label>
                                    <input name="student_id" type="student_id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $student_id; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH DATE
                                    </label>
                                    <input name="name" type="name"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value=<?php echo $birth_date; ?> disabled />
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
                                    value="<?php echo $name; ?>" disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH PLACE</label>
                                <input name="birth_place" type="birth_place"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $birth_place; ?>" disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>IC</label>
                                <input name="ic" type="ic"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    value="<?php echo $ic; ?>" disabled>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>FAVOURITE FOOD
                                    </label>
                                    <input name="birth_cert_no" type="birth_cert_no"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $fav_food; ?>" disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>BIRTH CERTIFICATION
                                    </label>
                                    <input name="fav_food" type='fav_food'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        value="<?php echo $birth_cert_no; ?>" disabled>
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
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>PREVIOUS SCHOOL
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="prev_school" value="<?php echo $prev_school; ?>" disabled>
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
                                            echo 'MUALAF';
                                        }
                                        ?>" disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ILLNESS
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="illness" value="<?php echo $illness; ?>" disabled>
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
        <div class="container-box pb-20" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 my-0">
                <div class="container mx-auto border-2">
                    <div class="inputs w-full y-full max-w-xl p-6">
                        <div class='flex items-center justify-between mt-2'>           
                            <div class="personal w-full md:w-full pt-2">
                                <h6 class="text-blueGray-400 text-xs mt-5 mb-4 uppercase">
                                    Student Information
                                </h6>  
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-auto md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>FIRST NAME</label>
                                    <input
                                        class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="first_name" value="<?php echo $first_name; ?>" disabled/>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>LAST NAME</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='text' name="last_name" value="<?php echo $last_name; ?>" disabled/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <div class='w-auto md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>RELATION</label>
                                    <input
                                        class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='relation' name="relation" value="<?php echo $relation; ?>" disabled/>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>MOBILE NO/label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='mobile_no' name="mobile_no" value="<?php echo $mobile_no; ?>" disabled/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <div class='w-auto md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>SPOUSE FIRST NAME</label>
                                    <input
                                        class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='text' name="home_no" value="<?php echo $home_no; ?>" disabled/>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>SPOUSE LAST NAME</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2'
                                        type='text' name="mobile_no" value="<?php echo $mobile_no; ?>" disabled/>
                                </div>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6 mt-0'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>EMAIL
                                </label>
                                <input
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                    type='email' name="email" value="<?php echo $email; ?>" disabled />
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>IC
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4'
                                        type='ic' name="ic" value="<?php echo $ic; ?>" disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>LC</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3'
                                        type='lc' name="lc" value="<?php echo $lc; ?>" disabled />
                                </div>
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