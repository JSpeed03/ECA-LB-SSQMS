<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../DBConn.php';  // Adjust the path if needed

$response = array();

if (isset($_POST['TransactionID']) && isset($_POST['transactionCode']) && isset($_POST['description']) && isset($_POST['departmentID'])) {
    $transactionID = $_POST['TransactionID'];
    $transactionCode = $_POST['transactionCode'];
    $description = $_POST['description'];
    $departmentID = $_POST['departmentID'];

    if (empty($transactionID) || empty($transactionCode) || empty($description) || empty($departmentID)) {
        $response['success'] = false;
        $response['error'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE transaction SET Code = ?, description = ?, departmentID = ? WHERE transactionID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssii", $transactionCode, $description, $departmentID, $transactionID);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = 'Failed to update transaction.';
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Failed to prepare the SQL statement.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request.';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
