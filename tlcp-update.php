<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $stateid = $_POST['stateid'];
    $bizstype = $_POST['bizstype'];
    $lcid = $_POST['lcid'];
    $opsname = $_POST['operatorname'];
    $ownername = $_POST['ownername'];
    $email= $_POST['eduemail'];
    $kindernohp= $_POST['kindernohp'];

    $sql = "UPDATE lcdetails (id,stateid,bizstype,lcid,operatorname,ownername,eduemail,kindernohp) 
    VALUES ('$id','$stateid','$bizstype','$lcid','$opsname','$ownername','$email','$kindernohp')";
    $result = mysqli_query($conn, $sql); 
    if ($result)
        echo "<script>alert('SUCCESFULL ADD NEW TLCP')</script>";
    else 
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='tlcp-add.php'</script>";
}
$id= $_GET['id'];
$sql = "SELECT * FROM lcdetails WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);
while ($r = mysqli_fetch_array($result)) {
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
    <title>TLCP Update</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- component -->
    <!-- component -->
    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 font-mono my-0">
            <div class="container mx-auto">
                <div class="inputs w-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900"><?php echo $lcid ?></h2>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ID
                                    </label>
                                    <input name="id" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $id ?> />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>State
                                        ID
                                    </label>
                                    <input name="stateid" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $stateid ?> />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Biz
                                        Type
                                    </label>
                                    <input name="bizstype" type='text'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                         value=<?php echo $bizstype ?> />
                                </div>
                            </div>
                            <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Little
                                    Caliph
                                    ID</label>
                                <input name="lcid" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $lcid ?> />
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operator
                                    Name</label>
                                <input name="operatorname" type="text" 
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $opsname ?> />
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner
                                    Name</label>
                                <input name="ownername" type="text"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                     value=<?php echo $ownername ?> />
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Status
                                    </label>
                                <input name="status" type="status"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $status; ?> />
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Year
                                        Signed
                                    </label>
                                <input name="yearsigned" type='yearsigned'
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $yearsigned ?> />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2' >Date
                                        Signed
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="datesigned" value=<?php echo $datesigned ?> />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date
                                        Operated
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="dateoperated" value=<?php echo $dateoperated ?> />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TLCP
                                        Package
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="tlcppackage" value=<?php echo $tlcppackage ?> />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-0">
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Annual
                                        License
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="annuallicense" value=<?php echo $annuallicense ?> />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Edu
                                        Email
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="eduemail" value=<?php echo $eduemail ?> />
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</body>
</html>
<?php include "COMPONENT/footer.php" ?>