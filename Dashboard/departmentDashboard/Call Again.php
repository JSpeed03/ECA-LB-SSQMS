<?php
session_start();
require '../../DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'queue_id' field exists in the POST data
    if (isset($_POST['queue_id'])) {
        // Retrieve the ID from the POST data
        $queue_id = $_POST['queue_id'];
       
        $logged_in_department = $_SESSION['department_id'];

        
        $update = "UPDATE `queue` SET `Status`='Called', `Time Called`=now() WHERE `Queue identifier` = '$queue_id' ";

        $res = mysqli_query($conn, $update);

        if ($res) {
          header("Location: index.php?success= Called Again Successfully");
        }
    } else {

        header("Location: index.php?error= Called Again Failed");
    }
} else {
    echo "Form data not submitted.";
}
?>
