<?php
require '../.././DBConn.php';

// Fetch departments from the database
$departmentsQuery = "SELECT departmentID, Description FROM departments";
$departmentsResult = $conn->query($departmentsQuery);
$departments = [];

while ($row = $departmentsResult->fetch_assoc()) {
    $departments[] = $row;
}

// Encode data to JSON format
$data = [
    'departments' => $departments,
];

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
exit; // Stop further execution
?>