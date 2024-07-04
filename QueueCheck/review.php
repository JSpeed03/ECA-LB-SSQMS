<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../DBConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queueNumber = $_POST['quenumber'];
    $regText = $_POST['regtext'];
    $digit = $_POST['digit'];
    $today = date('Y-m-d');
    

    if (!empty($queueNumber) && !empty($regText)) {
      
        $sql = "SELECT 

        CONCAT(d.`Department_code`, '-', LPAD(q.`Queue Number`, 4, '0')) AS queue_number,
        ut.`code` AS user_type, 
        CONCAT(s.`Lastname`, ', ', s.`Firstname`) AS student_name, 
        s.`Lastname` AS name, 
        q.`Status` AS Status,
        q.`Student ID` AS id, 
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
    LEFT JOIN `window` w ON q.`Window_ID` = w.`windowID` 
                WHERE d.Department_code = '$regText' and `Queue Number` = '$digit' AND DATE(q.`Time Created`) = '$today' ";

        $result = mysqli_query($conn, $sql);

        if ($result) {
          
            if (mysqli_num_rows($result) > 0) {
            
              $row = mysqli_fetch_assoc($result);
                  
                
                    
                
   ?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Details</title>
    <link rel="stylesheet" href="reviewstyle.css">
    <link href="../logo/QMS-logo.png" rel="icon">
</head>
<body>
    <div class="container">
        <h2>Review Your Details</h2>
        <p><strong>User Type:</strong> <?php echo $row['user_type'] ?></p>
        <p><strong>ID Number or Name:</strong> <?php echo $row['id'] ?></p>
        <p><strong>Fullname:</strong> <?php echo $row['student_name'] ?></p>
        <p><strong>Department:</strong> <?php echo $row['department_name'] ?></p>
        <p><strong>Transaction:</strong> <?php echo $row['transaction_name'] ?></p>
        <p><strong>Time Created:</strong><?php echo $row['time_created'] ?></p>
        <p><strong>Time Called:</strong><?php echo $row['time_called'] ?></p>
        <p><strong>Time Finished:</strong><?php echo $row['time_finished'] ?></p>
        <p><strong>Status:</strong><?php echo $row['Status'] ?></p>
      

        <a href="index.php"><button type="button">Check Another Queue</button></a>
        <a href="../index.php">
            <button type="submit" style="background-color: #e3ff37; border: none; padding: 16px 30px; font-size: 16px; cursor: pointer;">Home</button>
        </a>
        <?php
        if ($row['transaction_name'] == 'Enrollment') {
           ?>
            <a href="nextStep.php"><button type="button">Check Step</button></a>
            <?php
        }else{

        }
        
        ?>
        
    </div>

    <script>
        // Set the inactivity timeout in milliseconds
  const inactivityTimeout = 300000; // 5 minutes

// Set the inactivity timer
let inactivityTimer = setTimeout(() => {
  // Redirect to the index page
  window.location.href = '../index.html';
}, inactivityTimeout);

// Reset the inactivity timer on user activity
document.addEventListener('mousemove', () => {
  clearTimeout(inactivityTimer);
  inactivityTimer = setTimeout(() => {
    window.location.href = '../index.html';
  }, inactivityTimeout);
});

document.addEventListener('keypress', () => {
  clearTimeout(inactivityTimer);
  inactivityTimer = setTimeout(() => {
    window.location.href = '../index.html';
  }, inactivityTimeout);
});
    </script>
</body>
</html>
<?php 


} else {
    echo "<script>alert('404 Queue Number not found'); window.history.back();</script>";
}
} else {
echo "Error executing query: " . mysqli_error($conn);
}
} else {
echo "Queue number and department code must be provided.";
}
} else {
echo "Invalid request method.";
}
?>
