<?php
include "COMPONENT/DB/config.php";

    // Initialize variables
$user_id = $name = $password = $confirm_password = $type = $department = "";
$user_id_err = $name_err = $password_err = $confirm_password_err = $type_err = $department_err = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user id
    if (empty(trim($_POST["user_id"]))) {
        $user_id_err = "Please enter a Staff ID.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a Name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    //Validate type
    if (empty(trim($_POST["type"]))) {
        $type_err = "Please enter your type.";
    } elseif ($_POST["type"] !== "admin" && $_POST["type"] !== "user") {
        $type_err = "Only HOD & CS can access to Admin.";
    } else {
        $type = trim($_POST["type"]);
    }

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter a department.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Check for errors before inserting into database
    if (empty($user_id_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($type_err) && empty($department_err)) {
        // Prepare an insert statement
        $insert_query = "INSERT INTO users (user_id, name, password, type, department) VALUES (?, ?, ?, ?, ?)";

        if ($insert_stmt = mysqli_prepare($conn, $insert_query)) {
            // Bind variables to the prepared statement
            mysqli_stmt_bind_param($insert_stmt,'sssss', $user_id, $name, $password, $type, $department);

            // Execute the prepared statement
            if (mysqli_stmt_execute($insert_stmt)) {
                echo "<script>alert('User registered successfully.'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Error registering user,Please try again...'); window.location.href = 'register.php';</script>";
            }

            // Close the statement
            mysqli_stmt_close($insert_stmt);
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
    <div class="bg-grey-lighter max-h-screen flex-col">
        <div class="container max-w-sm mx-auto flex flex-col items-center justify-center px-2 mt-0 mb-20">
            <div class="bg-white px-6 py-3 rounded shadow-md text-black w-full md:full">
                <h2 class="text-2xl text-center">Register New User</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div>
                        <label>Staff ID:</label>
                        <input type="text" name="user_id" class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $user_id; ?>">
                        <span><?php echo $user_id_err; ?></span>
                    </div>
                    <div>
                        <label>Name:</label>
                        <input type="text" name="name" class="block border border-grey-light w-full p-2 rounded mb-2"
                            value="<?php echo $name; ?>">
                        <span><?php echo $name_err; ?></span>
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
                        <label>Type:</label>
                        <select name="type" id="type" class="block border border-grey-light w-full p-2 rounded mb-2">
                            <option value="" hidden>Only HOD & CS can be an Admin </option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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
                    <div>
                        <input type="submit" value="Register"
                            class=" text-white w-full bg-sky-400 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 p-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php include "COMPONENT/footer.php" ?>