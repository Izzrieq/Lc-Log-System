<?php
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
        exit;
    }
    
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

    $sql = "INSERT INTO lcdetails (id,stateid,bizstype,lcid,operatorname,ownername,eduemail,kindernohp) 
    VALUES ('$id','$stateid','$bizstype','$lcid','$opsname','$ownername','$email','$kindernohp')";
    $result = mysqli_query($conn, $sql); 
    if ($result){
        echo "<script>alert('SUCCESFULL ADD NEW TLCP')</script>";
        echo "<script>window.location='tlcp-data.php'</script>";
    }else{ 
        echo "<script>alert('SORRY, YOU FAILED..TRY AGAIN! :( ')</script>";
        echo "<script>window.location='tlcp-add.php'</script>";
}

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLCP ADD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css">

</head>

<body class="bg-neutral-50">
    <!-- component -->  
    <div>                              
        <button class="rounded-md bg-blue-700 text-white text-sm px-3 py-2 m-2" type="back" onclick="history.back()">BACK
        <i class="fa fa-undo" aria-hidden="true"></i>
        </button>
    </div>
    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="bg-gray-200 min-h-screen pt-0 mt-0 mb-4">
            <div class="container mx-auto">
                <form action="tlcp-add.php" method="POST" name="form-tlcp-add">
                    <div class="inputs w-full max-w-xl p-6">
                        <div class='flex items-center justify-between mt-2'>
                            <div class="personal w-full pt-2">
                                <h2 class="text-center text-2xl font-bold text-gray-900">ADD TLCP</h2>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>ID
                                        </label>
                                        <input name="id" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>State
                                            ID
                                        </label>
                                        <input name="stateid" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-6'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Biz
                                            Type
                                        </label>
                                        <input name="bizstype" type='text'
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                    </div>
                                </div>
                                <div class='w-full md:w-1/2 px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Little
                                        Caliph
                                        ID</label>
                                    <input name="lcid" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Operator
                                        Name</label>
                                    <input name="operatorname" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Owner
                                        Name</label>
                                    <input name="ownername" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500' />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Kindergarten
                                        Number
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="kindernohp" />
                                </div>
                                <div class='w-full md:w-full px-3 mb-6'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 font-medium font-bold mb-2'>Edu
                                        Email
                                    </label>
                                    <input
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                                        type='text' name="eduemail" />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button
                                class="w-full pr-4 bg-green-500 hover:bg-green-700 text-white font-medium font-bold py-2.5 px-3 border border-green-700 rounded"
                                type="submit">SUBMIT</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
</body>

</html>