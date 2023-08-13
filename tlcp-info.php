<?php
include_once "COMPONENT/DB/config.php";
include "COMPONENT/header.php";
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM lcdetails WHERE id='$id'");
 while ($r = mysqli_fetch_array($data))
{
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

<body>
    <!-- component -->
    <!-- component -->
    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 font-mono my-0">
            <div class="container mx-auto">
                <div class="inputs w-full max-w-xl p-6">
                    <div class='flex items-center justify-between mt-2'>
                        <div class="personal w-full pt-2">
                            <h2 class="text-2xl text-gray-900">TLCP info:</h2>
                            <div class="flex items-center justify-between mt-4">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>ID
                                    </label>
                                    <input name="id" type="id"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $r["id"]; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>State
                                        ID
                                    </label>
                                    <input name="stateid" type="stateid"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        value=<?php echo $r["stateid"]; ?> disabled />
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Biz
                                        Type
                                    </label>
                                    <input name="bizstype" type='bizstype'
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                         value=<?php echo $r["bizstype"]; ?> disabled>
                                </div>
                            </div>
                            <div class='w-full md:w-1/2 px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Little
                                    Caliph
                                    ID</label>
                                <input name="lcid" type="lcid"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $r["lcid"]; ?> disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label
                                    class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operator
                                    Name</label>
                                <input name="operatorname" type="operatorname" 
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $r["operatorname"]; ?>  disabled>
                            </div>
                            <div class='w-full md:w-full px-3 mb-6'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Owner
                                    Name</label>
                                <input name="ownername" type="ownername"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                     value=<?php echo $r["ownername"]; ?> disabled>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Status
                                    </label>
                                <input name="status" type="status"
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $r["status"]; ?> disabled>
                                </div>
                                <div class='w-full md:w-2/5 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Year
                                        Signed
                                    </label>
                                <input name="yearsigned" type='yearsigned'
                                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                    value=<?php echo $r["yearsigned"]; ?> disabled>
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
                                        type='text' name="datesigned" value=<?php echo $r["datesigned"]; ?> disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Date
                                        Operated
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="stateid" value=<?php echo $r["dateoperated"]; ?> disabled>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>TLCP
                                        Package
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="bizstype" value=<?php echo $r["tlcppackage"]; ?> disabled>
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
                                        type='text' name="annuallicense" value=<?php echo $r["annuallicense"]; ?> disabled>
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Edu
                                        Email
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="eduemail" value=<?php echo $r["eduemail"]; ?> disabled>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
        ?>
<?php
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM lcdetails WHERE id='$id'");
 while ($r = mysqli_fetch_array($data))
{
?>
        <div class="container-box" style="display: flex;">
            <div class="bg-gray-200 min-h-screen pt-0 font-mono my-0">
                <div class="container mx-auto">
                    <div class="inputs w-full y-full max-w-xl p-6 border-l-4 border-gray-400">
                        <!-- <div class='flex items-center justify-between mt-2'> -->
                            <div class="personal w-full md:w-full pt-2">
                                <div class='w-full md:w-full px-3 mb-6 pt-4'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Kindergarten
                                        Name</label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='kindername' name="kindername" value=<?php echo $r["kindername"]; ?> disabled>
                                </div>
                                <div class='w-auto md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Kindergarten
                                        Number</label>
                                    <input
                                        class='appearance-none block w-auto bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='kindernohp' name="kindernohp" value=<?php echo $r["kindernohp"]; ?> disabled>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-full md:w-1/4 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>No.Block/House</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='noblock' name="noblock" value=<?php echo $r["noblock"]; ?> disabled>
                                    </div>
                                    <div class='w-full md:w-full px-3 mb-6 ml-8'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Street</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='street' name="street" value=<?php echo $r["street"]; ?> disabled>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-full md:w-1/3 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Post
                                            Code</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='postcode' name="postcode" value=<?php echo $r["postcode"]; ?> disabled>
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>City
                                        </label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='text' name="city" value=<?php echo $r["city"]; ?> disabled>
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>State
                                        </label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='text' name="state" value=<?php echo $r["state"]; ?> disabled>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type
                                        </label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='text' name="type" value=<?php echo $r["type"]; ?> disabled>
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operater
                                            Number</label>
                                        <input
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                            type='text' name="operatornohp" value=<?php echo $r["ownernohp"]; ?> disabled>
                                    </div>
                                </div>
                                <div class='w-auto md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Operator
                                        Address</label>
                                    <textarea name="operatoraddress"
                                        class='bg-white rounded-md border leading-normal resize-none w-full h-20 py-2 px-3 shadow-inner border border-gray-400 font-medium placeholder-gray-700 focus:outline-none focus:bg-white'
                                        disabled><?php echo $r["operatoraddress"]; ?></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        class="appearance-none bg-gray-200 text-gray-900 px-2 py-1 shadow-sm border border-gray-400 rounded-md mr-3"
                                        type="submit">save changes</button>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
            <?php
}
        ?>
</body>
</html>
<?php include "COMPONENT/footer.php" ?>