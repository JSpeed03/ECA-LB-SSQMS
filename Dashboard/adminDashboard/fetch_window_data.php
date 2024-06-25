<?php
include '../.././DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: ". $conn->connect_error]));
}

$sql = "SELECT 
    sw.`staffwindowID` AS `staffwindowID`,
    d.`Department_code` AS `department_code`,
    w.`window` AS `window`,
    sa.`Username` AS `staff_username`
FROM `staff-window` sw
JOIN `departments` d ON sw.`Department id` = d.`departmentID`
JOIN `window` w ON sw.`Window_ID` = w.`windowID`
JOIN `staff_account` sa ON sw.`Staff ID` = sa.`accountID`";

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