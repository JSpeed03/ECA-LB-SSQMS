<?php
include '../DBConn.php';
session_start(); // Start the session at the beginning

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $username = validate($_POST['uname']);
    $raw_password = validate($_POST['password']); // Validate the password as well

    if (empty($username)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } else if (empty($raw_password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT accountID, Department_ID, Authority_ID, Password FROM staff_account WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($raw_password, $row['Password'])) {
                // Set session variables
                $_SESSION["accountID"] = $row['accountID'];
                $_SESSION["username"] = $username;
                $_SESSION["department_id"] = $row['Department_ID'];
                $_SESSION["authority_id"] = $row['Authority_ID'];

                // Redirect based on the department and authority
                if (is_null($row['Department_ID'])) {
                    if ($row['Authority_ID'] >= 3) {
                        header("Location: ../Dashboard/adminDashboard");
                    } else {
                        header("Location: ../error/insufficientPrivileges");
                    }
                } else {
                    header("Location: ../Dashboard/departmentDashboard?department_id=" . $row['Department_ID']);
                }
                exit();
            } else {
                header("Location: index.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
