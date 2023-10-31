<?php
error_reporting(0);
include "COMPONENT/DB/config.php";

    // Initialize variables
$user_id = $username = $password = $confirm_password = $type = $department = $fullname = $email = $nohp = $ic = $address = $marriage_status = "";
$user_id_err = $username_err = $password_err = $confirm_password_err = $type_err = $department_err = $fullname_err = $email_err = $nohp_err = $ic_err = $address_err = $marriage_status_err = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user id
    if (empty(trim($_POST["user_id"]))) {
        $user_id_err = "Please enter a Staff ID.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }
    // Validate name
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a Name.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "<p style='color: red;'>Password must have at least 6 characters *</p>";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "<p style='color: red;'>Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "<p style='color: red;'>Password did not match.";
        }
    }

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "<p style='color: red;'>Please enter a department.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Validate fullname
    if (empty(trim($_POST["fullname"]))) {
        $fullname_err = "<p style='color: red;'>Please enter your Full Name.";
    } else {
        $fullname = trim($_POST["fullname"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "<p style='color: red;'>Please enter your Email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["nohp"]))) {
        $nohp_err = "<p style='color: red;'>Please enter your Tel.No .";
    } else {
        $nohp = trim($_POST["nohp"]);
    }

    if (empty(trim($_POST["ic"]))) {
        $ic_err = "<p style='color: red;'>Please enter your IC/MyKad.";
    } else {
        $ic = trim($_POST["ic"]);
    }

    if (empty(trim($_POST["address"]))) {
        $address_err = "<p style='color: red;'>Please enter your Address.";
    } else {
        $address = trim($_POST["address"]);
    }

    if (empty(trim($_POST["marriage_status"]))) {
        $marriage_status_err = "<p style='color: red;'>Please enter your marriage status.";
    } else {
        $marriage_status = trim($_POST["marriage_status"]);
    }

    // Check for errors before inserting into database

    $type = 'user';
    if (empty($user_id_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($type_err) && empty($department_err) && empty($fullname_err) && empty($email_err) && empty($nohp_err) && empty($ic_err) && empty($address_err) && empty($marriage_status_err)) {
        // Prepare an insert statement
        $insert_query = "INSERT INTO users (user_id, username, password, type, department, fullname, email, nohp, ic, address, marriage_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        if ($insert_stmt = mysqli_prepare($conn, $insert_query)) {
            // Bind variables to the prepared statement
            mysqli_stmt_bind_param($insert_stmt, 'sssssssssss', $user_id, $username, $password, $type, $department, $fullname, $email, $nohp, $ic, $address, $marriage_status);
    
            // Execute the prepared statement
            if (mysqli_stmt_execute($insert_stmt)) {
                echo "<script>alert('User registered successfully.'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Error registering user. Error: ".mysqli_error($conn)."'); window.location.href = 'register.php';</script>";
            }
    
            // Close the statement
            mysqli_stmt_close($insert_stmt);
        } else {
            echo "<script>alert('Error: ".mysqli_error($conn)."'); window.location.href = 'register.php';</script>";
        }
    }

}
        //Fetch department options from the database
        $departments_query = "SELECT * FROM departments";
        $departments_result = mysqli_query($conn, $departments_query);
        $departments = mysqli_fetch_all($departments_result, MYSQLI_ASSOC);

    // Close the connection
    mysqli_close($conn);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-neutral-50 m-0 p-0 font-large font-sans">
    <header class="d-flex justify-content-between bg-white ">
        <div class="w-25 p-0 h-25 d-inline-block">
            <a href="index.php">
                <img class="w-full m-0 h-100 d-inline-block" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png"
                    alt="logo">
            </a>
        </div>
        <div class="p-0">
            <h1 class="m-3 text-primary">BLISS CUSTOMER E-LOG</h1>
        </div>
    </header>

    <div class="container-box" style="display: flex; justify-content:center;">
        <div class="container" style="display: flex; width: 80%;">
            <!-- First Column for the form -->
            <div class="bg-white px-6 py-3 text-black" style="width: 45%;">
                <h2 class="text-2xl text-center">Register New User</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div>
                            <label>Staff ID:</label>
                            <input type="text" name="user_id" class="block border border-grey-light w-full p-2 rounded mb-2"
                                value="<?php echo $user_id; ?>">
                            <span><?php echo $user_id_err; ?></span>
                        </div>
                        <div>
                            <label>User Name:</label>
                            <input type="text" name="username" class="block border border-grey-light w-full p-2 rounded mb-2"
                                value="<?php echo $username; ?>">
                            <span><?php echo $username_err; ?></span>
                        </div>
                        <div>
                            <label>Password:</label>
                            <input type="password" name="password"
                                class="block border border-grey-light w-full p-2 rounded mb-2"
                                value="<?php echo $password; ?>">
                            <span><?php echo $password_err; ?></span>
                        </div>
                        <div>
                            <label>Confirm Password:</label>
                            <input type="password" name="confirm_password"
                                class="block border border-grey-light w-full p-2 rounded mb-2"
                                value="<?php echo $confirm_password; ?>">
                            <span><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div>
                            <label>Department:</label>
                            <select name="department" class="block border border-grey-light w-full p-2 rounded mb-2">
                                <?php foreach ($departments as $dept) { ?>
                                <option value="<?php echo $dept['department_name']; ?>"
                                    <?php echo ($department == $dept['department_name']) ? 'selected' : ''; ?>>
                                    <?php echo $dept['department_name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <span><?php echo $department_err; ?></span>
                        </div>           
                </div>
            <!-- Second Column for the other div -->
            <div class="bg-white px-6 py-3 text-black" style="width: 45%;">
                <h2 class="text-2xl text-center">Personal Information</h2>
                <!-- Content for the other div -->
                    <div>
                        <label>Full Name:</label>
                        <input type="text" name="fullname"
                        class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $fullname; ?>">
                        <span><?php echo $fullname_err; ?></span>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="text" name="email"
                        class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $email; ?>">
                        <span><?php echo $email_err; ?></span>
                    </div>
                    <div>
                        <label>No.Tel:</label>
                        <input type="text" name="nohp"
                        class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $nohp; ?>">
                        <span><?php echo $nohp_err; ?></span>
                    </div>
                    <div>
                        <label>IC/MyKad:</label>
                        <input type="text" name="ic"
                        class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $ic; ?>">
                        <span><?php echo $ic_err; ?></span>
                    </div>
                    <div>
                        <label>Addres:</label>
                        <input type="text" name="address"
                        class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $address; ?>">
                        <span><?php echo $address_err; ?></span>
                    </div>
                    <div>
                        <label>Marriage Status:</label>
                        <select type="text" name="marriage_status"
                        class="block border border-grey-light w-full p-2 rounded mb-2">
                        <option value="" disabled selected>Select an option</option>
                        <option value="Single" <?php if ($marriage_status === "Single") echo "selected"; ?>>Single</option>
                        <option value="Married" <?php if ($marriage_status === "Married") echo "selected"; ?>>Married</option>
                        </select>
                        <span><?php echo $marriage_status_err; ?></span>
                    </div>
                
                    <!-- Submit button -->
                    <div class="w-full px-6 py-3 text-black">
                        <input type="submit" value="Register" class="text-white w-full bg-sky-400 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 p-2">
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

<?php include "COMPONENT/footer.php" ?>