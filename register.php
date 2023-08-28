<?php
include "COMPONENT/DB/config.php";
    // Initialize variables
$username = $password = $confirm_password = $department = "";
$username_err = $password_err = $confirm_password_err = $department_err = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
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

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter a department.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Check for errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($department_err)) {
        // Prepare an insert statement
        $insert_query = "INSERT INTO users (username, password, type, department) VALUES (?, ?, 'user', ?)";

        if ($insert_stmt = mysqli_prepare($conn, $insert_query)) {
            // Bind variables to the prepared statement
            mysqli_stmt_bind_param($insert_stmt, "sss", $username, $password, $department);

            // Execute the prepared statement
            if (mysqli_stmt_execute($insert_stmt)) {
                echo "<script>alert('User registered successfully.'); window.location.href = 'home.php';</script>";
            } else {
                echo "<script>alert('Error registering user,Please try again...'); window.location.href = 'register.php';</script>";
            }

            // Close the statement
            mysqli_stmt_close($insert_stmt);
        }
    }

    // Close the connection
    mysqli_close($conn);
}
// Fetch department options from the database
$departments_query = "SELECT * FROM departments";
$departments_result = mysqli_query($conn, $departments_query);
$departments = mysqli_fetch_all($departments_result, MYSQLI_ASSOC);
?>
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

<body class="bg-neutral-50 m-0 p-0 font-medium md:font-serif ">
    <header class="d-flex justify-content-between bg-white ">
        <div class="w-25 p-0 h-25 d-inline-block">
            <a href="index.php">
                <img class="w-full m-0 h-100 d-inline-block" src="COMPONENT/img/LC_COMPANY LOGO_MARCH 2023-01.png"
                    alt="logo">
            </a>
        </div>
        <div class="p-0 ">
            <h1 class="m-3 h1 text-primary">BLISS CUSTOMER E-LOG</h1>
        </div>
    </header>
    <div class="bg-grey-lighter min-h-screen flex-col">
        <div class="container max-w-sm mx-auto flex flex-col items-center justify-center px-2 mt-2">
            <div class="bg-white px-6 py-3 rounded shadow-md text-black w-full md:full">
                <h2 class="text-2xl text-center">Register New User</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label>Username:</label>
                        <input type="text" name="username" class="block border border-grey-light w-full p-3 rounded mb-4" 
                         value="<?php echo $username; ?>">
                        <span><?php echo $username_err; ?></span>
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" name="password" class="block border border-grey-light w-full p-3 rounded mb-4"
                         value="<?php echo $password; ?>">
                        <span><?php echo $password_err; ?></span>
                    </div>
                    <div>
                        <label>Confirm Password:</label>
                        <input type="password" name="confirm_password" class="block border border-grey-light w-full p-3 rounded mb-4"
                         value="<?php echo $confirm_password; ?>">
                        <span><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div>
                        <label>Department:</label>
                        <select name="department" class="block border border-grey-light w-full p-3 rounded mb-4">
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
                        <input type="submit" value="Register" class="w-full text-white bg-sky-400 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 p-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php include "COMPONENT/footer.php" ?>