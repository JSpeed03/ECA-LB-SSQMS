<?php
require '../.././DBConn.php'; // Including the database connection file

// Fetch staff from the database
$staffQuery = "SELECT accountID, Username FROM staff_account";
$staffResult = $conn->query($staffQuery);
$staff = [];

while ($row = $staffResult->fetch_assoc()) {
    $staff[] = $row;
}

// Encode data to JSON format
$data = [
    'staff' => $staff,
];

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
exit; // Stop further execution
?>
