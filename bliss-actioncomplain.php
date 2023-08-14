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
    <title>Document</title>
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
</head>

<body>
    <section class=" py-1 bg-blueGray-50">
        <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
            <div
                class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                <div class="rounded-t bg-white mb-0 px-6 py-6">
                    <div class="text-center flex justify-between">
                        <h6 class="text-blueGray-700 text-xl font-bold">
                            ACTION COMPLAIN : <?php echo $cname; ?>
                        </h6>
                    </div>
                </div>
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                    <form id="issueform" class="issue" action="COMPONENT/FUNCTION/send.php" method="post">
                        <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                            Direct Email
                        </h6>
                        <hr class="mt-6 border-b-1 border-blueGray-300">
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlfor="grid-password">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlfor="grid-password">
                                        Subject
                                    </label>
                                    <input type="text" id="subject" name="subject"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                </div>
                            </div>


                            <div class="w-full lg:w-12/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                        htmlfor="grid-password">
                                        Message
                                    </label>
                                    <textarea type="text" id="message" name="message"
                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                        rows="4" value="test">Category: <?php echo $category; ?>, Type: <?php echo $type; ?>, Action Taken: </textarea>
                                </div>
                            </div>
                            <hr class="mt-6 border-b-1 border-blueGray-300">
                            <button name="submit"
                                class="bg-pink-500 w-full h-10 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                type="submit" name="send">
                                SUBMIT
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>

</html>
<?php
    //   include "COMPONENT/footer.php";
?>