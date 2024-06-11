<?php
include '../.././DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: ". $conn->connect_error]));
}

$sql = "SELECT 
`transaction`.`transactionID` AS `transactionID`,
`transaction`.`code` AS `code`,
`transaction`.`Description` AS `transaction_description`,
`departments`.`Description` AS `department_name`
FROM `transaction`
LEFT JOIN `departments` ON `transaction`.`DepartmentID` = `departments`.`departmentID`";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500); // Set the HTTP response status code to 500 (Internal Server Error)
    die(json_encode(["error" => "Query failed: ". $conn->error]));
}

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(["message" => "No data available"]);
}


?>