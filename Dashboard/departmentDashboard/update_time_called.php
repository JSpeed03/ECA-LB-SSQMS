<?php
session_start();
require '../../DBConn.php';
$logged_in_department = $_SESSION['department_id'];
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $logged_in_department;
    if (isset($_POST['queue_id'])) {
      
        $queue_id = $_POST['queue_id'];
        $date = date('Y-m-d H:i:s');
      
        $sql_query = "SELECT `staffwindowID` FROM `staff-window` WHERE `Department id`='$logged_in_department' ";

        $sql_res = mysqli_query($conn, $sql_query);

        if ($sql_res) {
            if (mysqli_num_rows($sql_res) > 0) {
                $row = mysqli_fetch_assoc($sql_res);
                $staff = $row['staffwindowID'];

                $update = "UPDATE `queue` SET `Status`='Called', `Window_ID`='$staff', `Time Called`='$date' 
                WHERE `Queue identifier` = '$queue_id'";
                $res = mysqli_query($conn, $update);


        if ($res) {
            header("Location: index.php?success= Called Successfully Successfully"); 

        }else {
            echo "No queue_id provagwgtwided in the form data.";
        }
    }else {
        echo "No queue_id provagwgtwided in the form data.";
    }
}else{
    echo "No queue_id provagwgtwided in the form data.";
}
    } else {

        echo "Form data not submitted.";
        echo "<script>alert('No Queue Available'); window.history.back();</script>"; // Add this line to display an alert message and go back to the previous page
        exit;
        
    }
} else {
    echo "Form data not submitted.";
    header("Refresh:2; url=" . $_SERVER["HTTP_REFERER"]); // Add this line to redirect back to the previous page after 2 seconds
    exit;
}
?>
