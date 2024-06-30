<?php
include "../../DBConn.php";

$id = $_POST['deletedata'];
$sql = "DELETE FROM `staff_account` WHERE accountID='$id'";

try {
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header("Location: AccMng.php?success=Account Deleted Successfully!");
        exit;
    } else {
        throw new Exception('Deletion failed');
    }
} catch (Exception $e) {
    echo "<script>alert('Deletion failed: ". $e->getMessage(). "'); history.back();</script>";
}
?>