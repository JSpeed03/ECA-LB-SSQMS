<?php
session_start();
include "../../DBConn.php";


if (isset($_POST['confirm']) && isset($_POST['new'])  ) {
    
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $raw_new = validate($_POST['new']);
    $newpass = password_hash( $raw_new, PASSWORD_DEFAULT);
    $confirm = validate($_POST['confirm']);
    $logged_in_department = $_SESSION['accountID'];

  if(!password_verify($confirm, $newpass)){
        header("Location: settings.php?error=Password confirmation doesn't match");

    }else{
        $sql2 = "UPDATE `staff_account` SET `Password`='$newpass' WHERE accountID = '$logged_in_department'";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {        
            header("Location: settings.php?success=Your Password has been Updated");
            exit();
        } 
    }
    
} else {
    header("Location: index.php");
    exit();
}
?>

=
