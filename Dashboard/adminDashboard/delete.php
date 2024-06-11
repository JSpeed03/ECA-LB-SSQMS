<?php
include "../../DBConn.php";

$id = $_POST['deletedata'];

$sql ="DELETE FROM `staff_account` WHERE accountID='$id' ";

$res = mysqli_query($conn, $sql);

if ($res) {
    header("Location: AccMng.php?success= Account Deleted Successfully!");
}








?>