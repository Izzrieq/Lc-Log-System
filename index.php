<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="COMPONENT/STYLE/style.css">

</head>
<style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
 }

</style>
<body class="m-0 p-0 font-sans md:font-serif overflow-y-hidden">
<header class="d-flex justify-content-between bg-white ">
        <div class="w-25 p-0 h-25 d-inline-block">
            <a href="index.php">
            <img  class="w-100 m-0 h-100 d-inline-block" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png" alt="logo">
            </a>
        </div>
        <div class="p-0 ">
            <h1 class="mt-5 m-3 h1 text-primary">BLISS CUSTOMER E-LOG</h1>
        </div>
</header>

<div class="flex flex-col h-screen bg-neutral-50">
    <div class="grid place-items-center sm:my-auto" x-data="{ showPass: true }">
        <div class="w-11/12 p-20 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 mb-36
                px-6 py-8 sm:px-12 sm:py-10
                bg-white rounded-lg shadow-xl shadow-blue-200">
            <div class="mb-4">
                <h6 class="font-bold text-[#063970] text-3xl">Login Page</h6>
            </div>
            <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
            <?php 
        } 
        ?>
        <center>
            <img src="COMPONENT/img/user.png" alt="user" class="h-1/6 w-1/6 pb-2">
        </center>
            <form class="space-y-5" action="COMPONENT/FUNCTION/login.php" method="POST">
                <div>
                    <input type="text" name="username" class="block w-full py-3 px-3 mt-2
                            text-gray-800 appearance-none
                            border-2 border-gray-100
                            focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" />
                </div>

                <div class="relative w-full">
                    <input :type="showPass ? 'password' : 'text'" name="password" class="block w-full py-3 px-3 mt-2 mb-4
                            text-gray-800 appearance-none
                            border-2 border-gray-100
                            focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <p class="font-semibold" @click="showPass = !showPass" x-text="showPass ? 'Show' : 'Hide'">Show
                        </p>
                    </div>
                </div>
                <a href="register.php">Register new staff</a>
                <span>|</span>
                <a href="forgotpass.php">Forgot Password</a>

                <button type="submit" class="w-full py-3 mt-10 bg-[#063970] rounded-md
                        font-medium text-white uppercase
                        focus:outline-none hover:shadow-none">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php include "COMPONENT/footer.php" ?>