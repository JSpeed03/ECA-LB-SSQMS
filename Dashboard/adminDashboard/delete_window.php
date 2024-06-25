<?php
include '../.././DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: ". $conn->connect_error]));
}

$staffwindowID = $_POST['staffwindowID'] ?? null;

if (!$staffwindowID) {
    http_response_code(400); // Set the HTTP response status code to 400 (Bad Request)
    die(json_encode(["error" => "Missing or invalid 'staffwindowID' parameter"]));
}

$sql = "DELETE FROM `staff-window` WHERE `staffwindowID` = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staffwindowID);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["message" => "Record deleted successfully"]);
} else {
    http_response_code(500); // Set the HTTP response status code to 500 (Internal Server Error)
    die(json_encode(["error" => "Delete failed: ". $conn->error]));
}

$stmt->close();
$conn->close();
?>