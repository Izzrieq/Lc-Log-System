<?php
include_once("DB/config.php");

if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $department = $_POST['department'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $marriage_status = $_POST['marriage_status'];

    // Check if an image file was uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Query to retrieve the user's current image
        $queryGetUserImage = "SELECT img FROM users WHERE user_id = ?";
        $stmtGetUserImage = $conn->prepare($queryGetUserImage);

        if ($stmtGetUserImage) {
            $stmtGetUserImage->bind_param('s', $user_id);
            $stmtGetUserImage->execute();
            $stmtGetUserImage->bind_result($currentImage);
            $stmtGetUserImage->fetch();
            $stmtGetUserImage->close();

            // Delete the old image from the server
            if (!empty($currentImage)) {
                $oldImagePath = "uploads/" . $currentImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Process the uploaded image
            $img_tmp_name = $_FILES['img']['tmp_name'];
            $img_name = $_FILES['img']['name'];

            // Define the directory where you want to save uploaded images
            $upload_directory = 'uploads/'; // Create a 'uploads' directory in your project

            // Generate a unique filename for the uploaded image
            $unique_filename = uniqid() . '_' . $img_name;

            // Move the uploaded image to the desired directory
            if (move_uploaded_file($img_tmp_name, $upload_directory . $unique_filename)) {
                // The image upload was successful, update the 'img' field in your database
                $img = $unique_filename; // Update the 'img' variable with the new filename
            } else {
                // Handle image upload error
                echo "<script>alert('Failed to upload profile picture.');</script>";
                exit;
            }
        } else {
            // Handle the case where prepare fails
            die("Prepare failed: " . $conn->error);
        }
    }

    // Check if the update has already been performed in this request
    if (!isset($_SESSION['update_complete'])) {
        // Update the user's profile in the database
        $update_query = "UPDATE users SET username='$username', department='$department', fullname='$fullname', email='$email', nohp='$nohp', ic='$ic', address='$address', marriage_status='$marriage_status'";

        // Only include the 'img' field update if a new image was uploaded
        if (isset($img)) {
            $update_query .= ", img='$img'";
        }

        $update_query .= " WHERE user_id='$user_id'";

        $result = mysqli_query($conn, $update_query);

        if ($result) {
            // Set the session variable to indicate the update is complete
            $_SESSION['update_complete'] = true;

            $_SESSION['username'] = $username;
            $_SESSION['type'] = $new_type_value;

            echo "<script>alert('Your profile information has been successfully updated.');</script>";
            echo "<script>window.location.href = '../home.php';</script>"; // Redirect to home.php
        } else {
            echo "<script>alert('Failed to update profile information: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Add this line to prevent further execution
exit;
?>
