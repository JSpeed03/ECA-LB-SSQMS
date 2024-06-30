<?php
require '../.././DBConn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = validate($_POST['uname']);
   
   
    $departmentID = validate($_POST['department']);
    $authority = validate($_POST['authority']);

    $raw_password = $_POST['password'];
    $password = password_hash($raw_password, PASSWORD_DEFAULT);
    $re_pass = validate($_POST['confirm']);

    if (empty($uname) || empty($password) || empty($re_pass) ) {
    header("Location: AccMng.php?error=" . urlencode("All fields are required") . "&$user_data");
    exit();
    } elseif ($password !== $re_pass) {
    header("Location: AccMng.php?error=" . urlencode("The confirmation password does not match") . "&$user_data");
    exit();
    } else if (strlen($password) < 8) {
    header("Location: AccMng.php?error=" . urlencode("Password must be at least 8 characters"));
    exit();
    } else if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
    header("Location: AccMng.php?error=" . urlencode("Password must contain at least one capital letter and one number"));
    exit();
    }
    else {
                 
                  
                    $sql2 = "INSERT INTO `staff_account`(`Username`, `Password`, `Authority_ID`, `Department_ID`) VALUES ('$uname','$password','$authority','$departmentID')";
                    $result2 = mysqli_query($conn, $sql2);

                    if ($result2) {
                 
                        header("Location: AccMng.php?success=Account Created");
                        exit();
                    } else {
                        header("Location: AccMng.php?error=Error Creation of Account");
                        exit();
                    }
                }
       
            }
       

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
