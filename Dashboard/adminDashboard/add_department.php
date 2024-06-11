<?php
// Include the database connection file
require '../.././DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $department_code = $_POST['DepartmentCode'];
    $description = $_POST['DepartmentDescription'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO departments (Department_code, Description) VALUES (?, ?)");
    $stmt->bind_param("ss", $department_code, $description);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: department.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
