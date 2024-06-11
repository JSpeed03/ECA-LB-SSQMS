<?php
require '../DBConn.php'; // Ensure this file contains the correct database connection setup

if (isset($_POST['idNumber'])) {
    $idNumber = $_POST['idNumber'];
    $response = ['valid' => false];

    // Debugging: Log the received idNumber
    error_log("Received idNumber: $idNumber");

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE studID = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('s', $idNumber);
    if ($stmt->execute() === false) {
        error_log("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->bind_result($count);
    $stmt->fetch();

    // Debugging: Log the count result
    error_log("Count result: $count");

    if ($count > 0) {
        $response['valid'] = true;
    }

    echo json_encode($response);
}
$conn->close();
exit;
?>
