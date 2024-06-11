<?php
include '../.././DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: ". $conn->connect_error]));
}

$input = json_decode(file_get_contents('php://input'), true);
$transactionID = $input['transactionID'];

if (!$transactionID) {
    echo json_encode(["error" => "Invalid transaction ID"]);
    exit;
}

$sql = "DELETE FROM `transaction` WHERE `transactionID` =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $transactionID);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Deletion failed: ". $stmt->error]);
}

$stmt->close();
$conn->close();
?>