<?php
include '../.././/DBConn.php';

header('Content-Type: application/json');

session_start();

// Check if the user is logged in and has a session variable storing their department ID
if (!isset($_SESSION['department_id'])) {
    die(json_encode(["error" => "User not logged in or department ID not set"]));
}

$logged_in_department = $_SESSION['department_id'];

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$date = isset($_GET['date']) ? $_GET['date'] : null;

$sql = "SELECT 

    CONCAT(d.`Department_code`, '-', LPAD(q.`Queue Number`, 4, '0')) AS queue_number,
    ut.`code` AS user_type, 
    CONCAT(s.`Lastname`, ', ', s.`Firstname`) AS c, 
    q.`Name` AS name, 
    d.`Description` AS department_name, 
    t.`Description` AS transaction_name, 
    q.`Transaction Step` AS transaction_step, 
    w.`window` AS window_name, 
    q.`Time Created` AS time_created, 
    q.`Time Called` AS time_called, 
    q.`Time Finnished` AS time_finished 
FROM `queue` q
LEFT JOIN `user type` ut ON q.`User Type ID` = ut.`usetypeID`
LEFT JOIN `student` s ON q.`Student ID` = s.`studID`
LEFT JOIN `departments` d ON q.`Department_ID` = d.`departmentID`
LEFT JOIN `transaction` t ON q.`Transaction ID` = t.`transactionID`
LEFT JOIN `window` w ON q.`Window_ID` = w.`windowID` WHERE (q.Status = 'Pending' OR q.Status = 'Called')
AND d.`departmentID` = " . intval($logged_in_department);

if ($date) {
    $sql .= " AND DATE(q.`Time Created`) = '" . $conn->real_escape_string($date) . "'";
}

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
    echo json_encode(["message" => "No data available for the specified date and department"]);
}


?>
