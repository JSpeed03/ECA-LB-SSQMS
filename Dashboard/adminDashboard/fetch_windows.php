<?php
require '../.././DBConn.php'; // Including the database connection file

// Fetch windows from the database
$windowsQuery = "SELECT windowID, `window` FROM `window`";
$windowsResult = $conn->query($windowsQuery);
$windows = [];

while ($row = $windowsResult->fetch_assoc()) {
    $windows[] = $row;
}

// Encode data to JSON format
$data = [
    'windows' => $windows,
];

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
exit; // Stop further execution
?>
