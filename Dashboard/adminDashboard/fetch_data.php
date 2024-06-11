<?php
include '../../DBConn.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$date = isset($_GET['date']) ? $_GET['date'] : null;

$sql = "SELECT 
    q.`Username` AS uname, 
    d.`Description` AS department_name, 
    s.`description` AS position
FROM `staff_account` q
LEFT JOIN `departments` d ON q.`Department_ID` = d.`departmentID`
LEFT JOIN `authority` s ON q.`Authority_ID` = s.`authorityID`";

$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$rows = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(["message" => "No data available for the specified date"]);
}

$conn->close();
?>
