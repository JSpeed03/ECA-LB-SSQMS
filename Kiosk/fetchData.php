<?php
require '../DBConn.php';

// Fetch departments
$departmentsQuery = "SELECT departmentID, Description FROM departments WHERE status = 1";
$departmentsResult = $conn->query($departmentsQuery);
$departments = [];
while ($row = $departmentsResult->fetch_assoc()) {
    $departments[] = $row;
}

// Fetch programs
$programQuery = "SELECT programID, transaction_ID, `Program Description` FROM program";
$programResult = $conn->query($programQuery);
$program = [];
while ($row = $programResult->fetch_assoc()) {
    $program[] = $row;
}

// Fetch transactions
$transactionsQuery = "SELECT transactionID, Description, DepartmentID FROM transaction";
$transactionsResult = $conn->query($transactionsQuery);
$transactions = [];
while ($row = $transactionsResult->fetch_assoc()) {
    $transactions[] = $row;
}

// Encode data to JSON format
$data = [
    'departments' => $departments,
    'transactions' => $transactions,
    'program' => $program,
];

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
exit; // Stop further execution
?>
