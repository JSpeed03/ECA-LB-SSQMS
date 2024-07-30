<?php
include '../.././DBConn.php'; // include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departmentID = $_POST['DepartmentID'];
    $departmentCode = $_POST['DepartmentCode'];
    $departmentDescription = $_POST['DepartmentDescription'];

    $sql = "UPDATE departments SET department_Code=?, description=? WHERE departmentID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $departmentCode, $departmentDescription, $departmentID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
