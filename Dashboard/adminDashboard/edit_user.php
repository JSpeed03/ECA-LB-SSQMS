<?php
require '../.././DBConn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['accountID'];
    $username = $_POST['uname'];
    $authority = $_POST['authority'];
    $department = $_POST['department'];

    $query = "UPDATE staff_account SET 
              Username = ?, 
              Authority_ID = ?, 
              Department_ID = ? 
              WHERE accountID = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'siii', $username, $authority, $department, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully";
            header("Location: AccMng.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error updating record: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
