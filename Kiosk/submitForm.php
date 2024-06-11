<?php
require '../DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['userType'];
    $idNumber = $_POST['idNumber'];
    $departmentID = $_POST['department'];
    $transactionID = $_POST['transaction'];
    $programID = isset($_POST['program']) && !empty($_POST['program']) ? $_POST['program'] : null;


    // Initialize variables for prepared statement
    $studentID = null;
    $name = null;

    if ($userType == 1) {
        // Old Student
        $studentID = intval($idNumber);

        // Validate if Student ID exists in the student table
        $stmt = $conn->prepare("SELECT studID FROM student WHERE studID = ?");
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Redirect to the error page if the student ID is invalid
            header("Location: error.php");
            exit;
        }
        $stmt->close();
    } else {
        // New Student or Visitor
        $name = $idNumber;
        $studentID = null;
    }

    // Generate the queue number
    $today = date('Y-m-d');

    // Get the last queue number used today for the department
    $stmt = $conn->prepare("SELECT last_number FROM queue_number_tracker WHERE departmentID = ? AND queue_date = ?");
    $stmt->bind_param("is", $departmentID, $today);
    $stmt->execute();
    $stmt->bind_result($lastNumber);
    $stmt->fetch();
    $stmt->close();

    if ($lastNumber === null) {
        $queueNumber = 1;
        // Insert new entry for today
        $stmt = $conn->prepare("INSERT INTO queue_number_tracker (departmentID, queue_date, last_number) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $departmentID, $today, $queueNumber);
        $stmt->execute();
        $stmt->close();
    } else {
        $queueNumber = $lastNumber + 1;
        if ($queueNumber > 9999) {
            $queueNumber = 1;
        }
        // Update the last number
        $stmt = $conn->prepare("UPDATE queue_number_tracker SET last_number = ? WHERE departmentID = ? AND queue_date = ?");
        $stmt->bind_param("iis", $queueNumber, $departmentID, $today);
        $stmt->execute();
        $stmt->close();
    }

    // Insert into the queue table
    $stmt = $conn->prepare("INSERT INTO queue (`Queue Number`, `User Type ID`, `Student ID`, `Name`, `Department_ID`, `Transaction ID`, `Window_ID`,`enrollment`, `Time Created`, `Status`, `Transaction Step`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending', '1')");

    // Default Window ID (this can be updated to dynamically assign windows if needed)
    $windowID = null;

    // Bind parameters
    $stmt->bind_param("iiisiisi", $queueNumber, $userType, $studentID, $name, $departmentID, $transactionID, $windowID, $programID);

    if ($stmt->execute()) {
        // Get the department code
        $stmt = $conn->prepare("SELECT Department_code FROM departments WHERE departmentID = ?");
        $stmt->bind_param("i", $departmentID);
        $stmt->execute();
        $stmt->bind_result($departmentCode);
        $stmt->fetch();
        $stmt->close();

        // Format the queue number with leading zeros
        $queueNumberFormatted = $departmentCode . str_pad($queueNumber, 4, '0', STR_PAD_LEFT);

        // Redirect to ticket.php with the queue number
        header("Location: ticket.php?queueNumber=" . urlencode($queueNumberFormatted));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect back to the form page if accessed directly
    header("Location: formPage.php");
    exit();
}
?>
