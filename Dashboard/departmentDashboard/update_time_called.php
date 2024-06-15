<?php
session_start();
require '../../DBConn.php'; // Ensure this file contains your database connection logic

if (!isset($_SESSION['accountID'])) {
    echo "User not logged in.";
    exit;
}

$logged_in_account = $_SESSION['accountID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['queue_id'])) {
        $queue_id = $_POST['queue_id'];

        // Prepare and execute the SQL query safely
        $stmt = $conn->prepare("SELECT `Window_ID` FROM `staff-window` WHERE `Staff ID` = ?");
        $stmt->bind_param("i", $logged_in_account);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $window_id = $row['Window_ID'];

            // Prepare and execute the update query safely
            $update_stmt = $conn->prepare("UPDATE queue SET `Status` = 'Called', `Window_ID` = ?, `Time Called` = NOW() WHERE `Queue identifier` = ?");
            $update_stmt->bind_param("ii", $window_id, $queue_id);
            $update_res = $update_stmt->execute();

            if ($update_res) {
                header("Location: index.php?success=Called Successfully");
                exit;
            } else {
                echo "Error updating the queue: " . $conn->error;
            }
        } else {
            echo "No window found for the logged-in user.";
        }

        $stmt->close();
    } else {
        echo "No queue_id provided in the form data.";
        echo "<script>alert('No Queue Available'); window.history.back();</script>";
        exit;
    }
} else {
    echo "Form data not submitted.";
    header("Refresh:2; url=" . $_SERVER["HTTP_REFERER"]);
    exit;
}

$conn->close();
?>
