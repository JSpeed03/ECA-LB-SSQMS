<?php
// Include the DB connection file
require_once '../.././DBConn.php';

// Get form data
$department_id = $_POST['departmentSelect'];
$window_id = $_POST['windowtSelect'];
$staff_id = $_POST['staffSelect']; 

// Insert data into staff-window table
$sql = "INSERT INTO `staff-window` (`Department id`, `Window_ID`, `Staff ID`) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $department_id, $window_id, $staff_id);
$stmt->execute();

// Check if data was inserted successfully
if ($stmt->affected_rows > 0) {
    header('Location: Windows.php'); 
} else {
    echo "Error inserting data: ". $stmt->error;
}

// Close connection
$conn->close();
?>