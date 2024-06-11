<?php
// Include the database connection file
require '../.././DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $transCode = $_POST['transCode'];
    $transDescription = $_POST['TransacDescrip'];
    $departmentCode = $_POST['departmentSelect']; 

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO transaction (`code`, `Description`, `DepartmentID`) VALUES (?,?,?)");
    $stmt->bind_param("sss", $transCode, $transDescription, $departmentCode);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: transaction.php'); // redirect to department.php after successful submission
    } else {
        echo "Error: ". $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Invalid request method";
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>