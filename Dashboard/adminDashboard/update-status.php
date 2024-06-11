<?php
include '../.././DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$input = json_decode(file_get_contents('php://input'), true);
$departmentID = $input['departmentID'];
$status = isset($input['status']) ? (int)$input['status'] : null; // Ensure status is integer

// Debugging: Log received input
error_log("Received departmentID: " . $departmentID);
error_log("Received status: " . $status);

if (!$departmentID || $status === null) {
    echo json_encode(["error" => "Invalid department ID or status"]);
    exit;
}

$sql = "UPDATE `departments` SET `status` = ? WHERE `departmentID` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $status, $departmentID);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Update failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
