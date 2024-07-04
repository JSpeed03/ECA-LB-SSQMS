<?php
session_start();
require '../../DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['queue_id'])) {

        $queue_id = $_POST['queue_id'];
        $date = date('Y-m-d H:i:s');
        $logged_in_department = $_SESSION['department_id'];

        $sql_query1 = "SELECT `Window_ID` FROM `staff-window` WHERE `Department id`='$logged_in_department'";
        $sql_res1 = mysqli_query($conn, $sql_query1);

        $sql_query2 = "SELECT `Transaction Step` FROM `queue` WHERE `Queue identifier`='$queue_id'";
        $sql_res2 = mysqli_query($conn, $sql_query2);

        if ($sql_res1 && $sql_res2) {
            if (mysqli_num_rows($sql_res1) > 0 && mysqli_num_rows($sql_res2) > 0) {
                $row1 = mysqli_fetch_assoc($sql_res1);
                $row2 = mysqli_fetch_assoc($sql_res2);

                $staff = $row1['Window_ID'];
                $step = $row2['Transaction Step'];


                if ( $step == '1') {
                    $step ='2';
                }elseif ($step =='2') {
                    $step ='3';
                }elseif ($step =='3') {
                    $step ='4';
                }elseif ($step =='4') {
                    $step ='5';
                }
                $update = "UPDATE `queue` SET `Status`='Finish', `Time Finnished`=NOw() WHERE `Queue identifier` = '$queue_id'";
                $res = mysqli_query($conn, $update);

   if ($res) {
      
       $sql1 = "SELECT `Queue identifier`, `Queue Number`,  `Transaction ID`, `User Type ID`, `Student ID`, `Name`, `Department_ID`, `Transaction ID`, `Transaction Step`, `Window_ID`, `Time Created`, `Time Called`, `Time Finnished`, `Status`, `enrollment`
                FROM queue
                WHERE `Queue identifier` = '$queue_id'";


       $result1 = mysqli_query($conn, $sql1);



       if ($result1 && $row = mysqli_fetch_assoc($result1)) {
           $queueNumber = $row['Queue Number'];
           $userTypeID = $row['User Type ID'];
           $studentID = $row['Student ID'];
           $name = $row['Name'];
           $departmentID = $row['Department_ID'];
           $transactionID = $row['Transaction ID'];
           $transactionStep = $row['Transaction Step'];
           $windowID = $row['Window_ID'];
           $timeCreated = $row['Time Created'];
           $timeCalled = $row['Time Called'];
           $timeFinished = $row['Time Finnished'];
           $program_Id = $row['enrollment'];

            
            if ($transactionStep !== '5') {
                if ($userTypeID = 1) {

                    if ( $transactionID == 17) {
                        if (in_array($departmentID, [1, 2, 4, 5, 8, 7, 11, 10, 9])) {
                            if ($departmentID == 2) {
                            
                                if ($transactionStep == '1') {
                                    $transactionStep = '2';
                                }elseif ($transactionStep == '4') {
                                    $transactionStep = '5';
                                }
                            $select = "SELECT `department_ID` FROM `program` WHERE `programID` = '$program_Id'";
                            $select_res = mysqli_query($conn, $select);
         
                            if ($select_res && $row = mysqli_fetch_assoc($select_res)) {
         
                             $newDepartmentID = $row['department_ID'];
                           
                            }
                             
                            } elseif ($departmentID == 1) {
                                if ($transactionStep == '3') {
                                    $transactionStep = '4';
                                }
                             $newDepartmentID = 2;
    
                             
                            } elseif ($departmentID == 4 || $departmentID == 5 || $departmentID == 8 || $departmentID == 7 || $departmentID == 9 || $departmentID == 11 || $departmentID == 10) {
                            
                                if (  $transactionStep == '2') {
                                    $transactionStep = '3';
                                }
                             $newDepartmentID = 1;
                            }
         
                          
                            $insert_sql = "INSERT INTO queue (`Queue Number`, `User Type ID`, `Student ID`, `Name`, `Department_ID`, `Transaction ID`, `Transaction Step`, `Window_ID`, `Time Created`, `Status`, `enrollment`)
                                           VALUES ('$queueNumber', '$userTypeID', '$studentID', '$name', '$newDepartmentID', '$transactionID', '$transactionStep', '$windowID', '$timeCreated', 'Pending',  '$program_Id')";
         
                            $insert_result = mysqli_query($conn, $insert_sql);
         
                            if ($insert_result) {
                               
                                $sql2 = "SELECT `Queue identifier` FROM queue WHERE `Time Created` = (SELECT MIN(`Time Created`) FROM queue WHERE Status='Pending' AND Department_ID = '$logged_in_department')";
                                $result2 = mysqli_query($conn, $sql2);
         
                                if ($result2 && $next_row = mysqli_fetch_assoc($result2)) {
                                    header("Location: index.php?error= No Called Queue");
                                } else {
                                 header("Location: index.php?error= No Called Queue");
                                }
                            } else {
                             header("Location: index.php?error= No Called Queue");
                            }
                        } else {
                            
                         header("Location: index.php?error= No Called Queue");
                        }
                    }else{
                        $sql2 = "SELECT `Queue identifier` FROM queue WHERE `Time Created` = (SELECT MIN(`Time Created`) FROM queue WHERE Status='Pending' AND Department_ID = '$departmentID')";
                        $result2 = mysqli_query($conn, $sql2);
         
                        if ($result2 && $next_row = mysqli_fetch_assoc($result2)) {
                         
                            header("Location: index.php?error= no Pending queue");
                          
                        } else {
                         header("Location: index.php?error= no Pending queue");
                        }
                    }
                }else{
                    if ( $transactionID == 17) {
                        if (in_array($departmentID, [1, 2, 4, 5, 8, 7, 11, 10, 9])) {
                            if ($departmentID == 2) {
                               
                            $select = "SELECT `department_ID` FROM `program` WHERE `programID` = '$program_Id'";
                            $select_res = mysqli_query($conn, $select);
         
                            if ($select_res && $row = mysqli_fetch_assoc($select_res)) {
         
                             $newDepartmentID = $row['department_ID'];
                           
                            }
                             
                            } elseif ($departmentID == 1) {
         
                             $newDepartmentID = 2;
                             
                            } elseif ($departmentID == 4 || $departmentID == 5 || $departmentID == 8 || $departmentID == 7 || $departmentID == 9 || $departmentID == 11 || $departmentID == 10) {
                           
                             $newDepartmentID = 1;
                            }
         
                          
                            $insert_sql = "INSERT INTO queue (`Queue Number`, `User Type ID`, `Student ID`, `Name`, `Department_ID`, `Transaction ID`, `Transaction Step`, `Window_ID`, `Time Created`, `Status`, `enrollment`)
                                           VALUES ('$queueNumber', '$userTypeID', null, '$name', '$newDepartmentID', '$transactionID', '$transactionStep', null, '$timeCreated', 'Pending',  '$program_Id')";
         
                            $insert_result = mysqli_query($conn, $insert_sql);
         
                            if ($insert_result) {
                               
                                $sql2 = "SELECT `Queue identifier` FROM queue WHERE `Time Created` = (SELECT MIN(`Time Created`) FROM queue WHERE Status='Pending' AND Department_ID = '$logged_in_department')";
                                $result2 = mysqli_query($conn, $sql2);
         
                                if ($result2 && $next_row = mysqli_fetch_assoc($result2)) {
                                    header("Location: index.php?error= No Called Queue");
         
                                } else {
                                 header("Location: index.php?error= No Called Queue");
                                }
                            } else {
                             header("Location: index.php?error= No Called Queue");
                            }
                        } else {
                            
                         header("Location: index.php?error= No Called Queue");
                        }
                    }else{
                  
                         header("Location: index.php?success= no Pending queue");
                      
                    }
                }
              
            }else {
                header("Location: index.php?Success= Enrollment Complete");
            }

           
          
       } else {
        header("Location: index.php?error= no Pending queue");
       }
   } else {
    header("Location: index.php?error= no Pending queue");
   }

}else{
    echo $logged_in_department;

}

        }else{
            echo "No queue_id provided in the form data.";
        
        }
       
        
      
    } else {
        header("Location: index.php?error=End Successfully");
    }
} else {
    header("Location: index.php?error=End Successfully");
}
?>
