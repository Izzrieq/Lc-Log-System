<?php
include("COMPONENT/DB/config.php");
include "COMPONENT/header.php";

if(isset($_POST['id'])) {
    $date = date("Y-m-d H:i:s");  
    $cname = $_POST['cname'];
    $cnohp = $_POST['cnohp'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $details = $_POST['details'];
    $lcid = $_POST['lcid'];
	$lcowner = $_POST['lcowner'];
    $ownernohp = $_POST['ownernohp'];

    $sql = "UPDATE complaintbliss (id, date, cname, cnohp, category, type, details, lcid, lcowner, ownernohp)
    VALUES ('$id', '$date', '$cname', '$cnohp', '$category', '$type', '$details', '$lcid', '$lcowner', '$ownernohp')";
    $result = mysqli_query($conn, $sql); 
    if ($result)
        echo "<script>alert('SUCCESFULL UPDATE')</script>";
    else 
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='bliss-operator.php'</script>";
}
$id= $_GET['id'];
$sql = "SELECT * FROM complaintbliss WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);
while ($r = mysqli_fetch_array($result)) {
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
    <title>TLCP Update</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 font-mono my-0">
            <div class="container mx-auto">
                <div class="inputs w-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900">Report <?php echo $lcid ?></h2>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ID
                                    </label>
                                    <input name="id" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $id; ?> />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date Complain
                                    </label>
                                    <input name="date" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $date; ?> />
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
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer Complain Name </label>
                                <input name="cname" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $cname; ?> />
                            </div>
                            <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer NO.HP
                                    </label>
                                    <input name="cnohp" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $cnohp; ?> />
                                </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Category</label>
                                <input name="category" type="text" 
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $category; ?> />
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type</label>
                                <input name="type" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                     value=<?php echo $type; ?> />
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Details</label>
                                <input name="details" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                     value=<?php echo $details; ?> />
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Lc Owner
                                    </label>
                                <input name="lcowner" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $lcowner; ?> />
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner No.Hp
                                    </label>
                                <input name="ownernohp" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $ownernohp; ?> />
                                </div>
                            </div>
                            </form>
                            <button  class="rounded-md bg-green-700 text-white p-2 m-2" onclick="window.print()" >Print</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</body>
</html>
