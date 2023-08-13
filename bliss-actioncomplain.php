<?php
      include "COMPONENT/header.php";
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
    <div class="m-3">
        <h1>Action For:</h1>
    </div>
    <div class="w-1/2 py-1 bg-blueGray-50">
        <div class="flex justify-start">
            <div class='w-full px-3 mb-6'>
                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer Name
                </label>
                <input name="id" type="id"
                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                    disabled />
            </div>
            <div class='w-full px-3 mb-6'>
                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Customer No.Hp
                </label>
                <input name="id" type="id"
                    class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                    disabled />
            </div>
        </div>
        <div class='w-full px-3 mb-6'>
            <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Category
            </label>
            <input name="id" type="id"
                class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                disabled />
        </div>
        <div class='w-full px-3 mb-6'>
            <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Type
            </label>
            <input name="id" type="id"
                class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                disabled />
        </div>
        <div class='w-full px-3 mb-6'>
            <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Detail Complain
            </label>
            <input name="id" type="id"
                class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-4 leading-tight focus:outline-none  focus:border-gray-500'
                disabled />
        </div>
        <div class="flex justify-center">
            <div class="flex justify-around space-x-5">
                <button type="button" class="btn btn-success w-full">Send Email</button>
                <button type="button" class="btn btn-danger w-full">Cancel</button>
            </div>
        </div>
    </div>
    <div>
        <form action="COMPONENT/FUNCTION/send.php" method="post">
            Email <input type="email" name="email" id=""> <br>
            Subject <input type="text" name="subject"> <br>
            Message <textarea name="message" id="" cols="30" rows="10"></textarea> <br>
            <button type="submit" name="send">Send</button>
        </form>
    </div>
    

</body>

</html>
<?php
    //   include "COMPONENT/footer.php";
?>