<?php
header('Content-Type: application/json');
require '../../DBConn.php'; // Include the database connection file

// Get POST data
$staffwindowID = $_POST['staffwindowID'];
$departmentID = $_POST['departmentID'];
$windowID = $_POST['windowID'];
$staffID = $_POST['staffID'];

// Update query
$sql = "UPDATE `staff-window` SET `Department id` = ?, Window_ID = ?, `Staff ID` = ? WHERE staffwindowID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $departmentID, $windowID, $staffID, $staffwindowID);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Window updated successfully!']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error updating record: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
