<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['formData'] = $_POST;
} else {
    header("Location: index.html");
    exit();
}

$formData = $_POST;

$userType = $formData['userType'];
$idNumber = $formData['idNumber'];
$departmentID = $formData['department'];
$transactionID = $formData['transaction'];
$programID = isset($formData['program']) && !empty($formData['program']) ? $formData['program'] : null;

require '../DBConn.php';

// Get department name
$stmt = $conn->prepare("SELECT Description FROM departments WHERE departmentID = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $departmentID);
$stmt->execute();
$stmt->bind_result($departmentName);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT `Program Description` FROM program WHERE programID = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $programID);
$stmt->execute();
$stmt->bind_result($programName);
$stmt->fetch();
$stmt->close();

// Get transaction name
$stmt = $conn->prepare("SELECT Description FROM transaction WHERE transactionID = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("i", $transactionID);
$stmt->execute();
$stmt->bind_result($transactionName);
$stmt->fetch();
$stmt->close();

$userTypeName = $userType == 1 ? 'Old Student' : ($userType == 2 ? 'New Student' : 'Visitor');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Review Details</title>
    <link href="../logo/exact logo - HD.png" rel="icon">
    <link rel="stylesheet" href="reviewstyle.css">

</head>
<body>
    <div class="container">
        <h2>Review Your Details</h2>
        <p><strong>User Type:</strong> <?php echo htmlspecialchars($userTypeName); ?></p>
        <p><strong>ID Number or Name:</strong> <?php echo htmlspecialchars($idNumber); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($departmentName); ?></p>
        <p><strong>Transaction:</strong> <?php echo htmlspecialchars($transactionName); ?></p>

<?php 

if (is_null($programID)) {
    # code...
}else{
    
    ?> <p><strong>Progam:</strong> <?php echo htmlspecialchars($programName); ?></p>
    <?php
}


?>

        <form method="POST" action="submitForm.php">
       
        <input type="checkbox" id="confirm" name="confirm" value="1" required> 
        <label for="confirm">The information is correct.</label> </br></br>

            
            <?php
            foreach ($formData as $key => $value) {
                echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
            }
            ?>
            <button type="submit" id="submit-btn">Print</button>
            <button type="button" onclick="window.location.href='index.html'">Go Back</button>
            <h3>By clicking 'Print,' you will be redirected to the next page. Click 'Print' on the next page or the queue will be invalid without a ticket.</h3>

        </form>
    </div>

    <script>
    document.getElementById('submit-btn').addEventListener('click', function(event) {
        if (!document.getElementById('confirm').checked) {
            event.preventDefault();
            alert('Please confirm that the information is correct.');
            }
        });
    </script>

</body>
</html>
