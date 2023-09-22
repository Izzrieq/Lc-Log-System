<?php                
include "../COMPONENT/DB/config.php";

try {
    $event_name = $_POST['event_name'];
    $event_start_date = date("y-m-d", strtotime($_POST['event_start_date'])); 
    $event_end_date = date("y-m-d", strtotime($_POST['event_end_date'])); 
    $department = $_POST['department'];
    $user_id = $_POST['user_id'];

    $insert_query = "INSERT INTO `events` (`event_name`, `event_start_date`, `event_end_date`, `department`, `user_id`) VALUES ('".$event_name."', '".$event_start_date."', '".$event_end_date."', '".$department."', '".$user_id."')";

    if (mysqli_query($conn, $insert_query)) {
        $data = array(
            'status' => true,
            'msg' => 'Event added successfully!'
        );
    } else {
        $data = array(
            'status' => false,
            'msg' => 'Sorry, Event not added.'
        );
    }
    echo json_encode($data);
} catch (Exception $e) {
    $data = array(
        'status' => false,
        'msg' => 'An error occurred: ' . $e->getMessage()
    );
    echo json_encode($data);
}
?>
