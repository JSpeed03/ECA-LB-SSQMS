<?php
include '../DBConn.php';

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
        el.`window` AS window_name, 
        CONCAT(d.`Department_code`, LPAD(pi.`Queue Number`, 4, '0')) AS queue_number
        FROM `queue` pi
        LEFT JOIN `window` el ON el.`windowID` = pi.`Window_ID`
        LEFT JOIN `departments` d ON pi.`Department_ID` = d.`departmentID`
        WHERE pi.`Status`='Called' OR pi.Status = 'Called Again'
        LIMIT 3";

if ($date) {
    $sql .= " AND DATE(pi.`Time Called`) = '" . $conn->real_escape_string($date) . "'";
}

$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$rows = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(["message" => "No data available for the specified date and department"]);
}
?>
