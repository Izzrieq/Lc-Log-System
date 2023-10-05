<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>alert('You must log in first.'); window.location.href = 'index.php';</script>";
    exit;
}
include("DB/config.php");


$img = $_SESSION['img'];
$user_id = $_SESSION['user_id'];
$result= mysqli_query($conn,"SELECT * FROM users WHERE user_id = '$user_id'");
while ($r = mysqli_fetch_array($result)) {
    $user_id = $r['user_id'];
    $username = $r['username'];
    $department = $r['department'];
    $fullname = $r['fullname'];
    $email = $r['email'];
    $nohp= $r['nohp'];
    $ic = $r['ic'];
    $address = $r['address'];
    $marriage_status = $r['marriage_status'];
    $img =$r['img'];

}

        //Fetch department options from the database
        $departments_query = "SELECT * FROM departments";
        $departments_result = mysqli_query($conn, $departments_query);
        $departments = mysqli_fetch_all($departments_result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<script>
    function uploadFile() {
        // Trigger the file input element
        document.getElementById('fileInput').click();

        // Listen for changes to the file input
        document.getElementById('fileInput').addEventListener('change', function () {
            var file = this.files[0]; // Get the selected file

            if (file) {
                // You can perform actions with the selected file here
                console.log('Selected file:', file.name);
            }
        });
    }
</script>

<body class="bg-gray-200">
    <button class="rounded-md bg-blue-700 text-white px-3 py-2" type="back" onclick="history.back()">BACK <i
            class="fa fa-undo" aria-hidden="true"></i>
    </button>
    <h1 style="text-align: center;" class="text-xl text-grey-700 font-bold p-2">Changes Account Profile</h1>
    <form action="setting-function.php" method="POST" enctype="multipart/form-data">
        <div class="container-box" style="display: flex; justify-content:center;">
            <div class="bg-white rounded-lg min-h-screen pt-0 my-0 mb-12">
                <div class="container mx-auto">
                    <div class="inputs w-full max-w-xl px-6 py-3">
                        <div class='flex items-center justify-between mt-2'>
                            <div class="personal w-full">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                                <div class="col-span-full">
                                    <div class="mt-2 flex items-center gap-x-3">
                                        <img class="rounded-image h-12 w-12 rounded-full"
                                            src="uploads/<?php echo $img ?>" alt="User Image">
                                        <path fill-rule="evenodd"
                                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                            clip-rule="evenodd" />
                                        </svg>
                                        <input type="file" name="img" id="fileInput" style="display: none;">
                                        <button id="changeImageButton" type="button"
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                            onclick="uploadFile()">
                                            Change Profile Picture
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-full md:w-1/2 px-3 mb-3'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>STAFF
                                            ID
                                        </label>
                                        <input name="user_id" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                            value="<?php echo $user_id; ?>" />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-3'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Username
                                        </label>
                                        <input name="username" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                            value="<?php echo $username; ?>" />
                                    </div>
                                </div>
                                <div class='w-full md:w-full px-3 mb-3'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Full
                                        Name
                                    </label>
                                    <input name="fullname" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                        value="<?php echo $fullname; ?>" />
                                </div>

                                <div class='w-full md:w-full px-3 mb-3'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Department
                                    </label>
                                    <select name="department"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'>
                                        <?php foreach ($departments as $dept) { ?>
                                        <option value="<?php echo $dept['department_name']; ?>"
                                            <?php echo ($department == $dept['department_name']) ? 'selected' : ''; ?>>
                                            <?php echo $dept['department_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class='w-full md:w-full px-3 mb-3'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Email
                                    </label>
                                    <input name="email" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                        value="<?php echo $email; ?>" />
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class='w-full md:w-1/2 px-3 mb-3'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>No.Telephone
                                        </label>
                                        <input name="nohp" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                            value="<?php echo $nohp; ?>" />
                                    </div>
                                    <div class='w-full md:w-1/2 px-3 mb-3'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>MyKad
                                            <span class="lowercase text-red-600">*without (-)</span>
                                        </label>
                                        <input name="ic" type="text"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                            value="<?php echo $ic; ?>" />
                                    </div>
                                </div>
                                <div class='w-full md:w-full px-3 mb-3'>
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Address
                                    </label>
                                    <textarea name="address" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-2 leading-tight focus:outline-none focus:border-gray-500'><?php echo $address; ?>
                                        </textarea>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class='w-full md:w-1/2 px-3 mb-2'>
                                        <label
                                            class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Status
                                        </label>
                                        <select name="marriage_status"
                                            class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'>
                                            <option value="<?php echo $marriage_status; ?>" disabled></option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="update"
                                        class="rounded-md bg-green-700 text-white p-2 mt-2">SAVE CHANGES
                                    </button>
                                </div>
                                <div class='w-full md:w-full px-3 mb-2'>
                                    <?php if ($_SESSION['marriage_status'] === 'Married') { ?>
                                    <label scope="col" class="text-md font-medium text-white px-2 py-2 border-r">
                                        Partner
                                    </label>
                                    <input name="partner" type="text"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'
                                        value="<?php echo $partner; ?>" />
                                    <label
                                        class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Role
                                    </label>
                                    <select name="role"
                                        class='appearance-none block w-full bg-white text-gray-700 border border-gray-400 shadow-inner rounded-md py-3 px-3 leading-tight focus:outline-none focus:border-gray-500'>
                                        <option value="" disabled selected>Husband / Wife</option>
                                        <option value="Husband">Husband</option>
                                        <option value="Wife">Wife</option>
                                    </select>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</body>

</html>