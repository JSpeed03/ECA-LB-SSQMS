<?php
require '../DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link href="../logo/exact logo - HD.png" rel="icon">
  <link rel="stylesheet" href="../Kiosk/style.css">
</head>
<body>
  <div class="container">
    <div class="user-type">
      <p>Enter your Queue Number</p>
      <form id="queueForm" method="POST" action="review.php">
    <label for="userType"></label>
        
    <input type="text" id="quenumber" name="quenumber" required placeholder="Queue Number">
    <input type="hidden" id="regtext" name="regtext">
    <input type="hidden" id="digit" name="digit">
    
    <button type="submit">Submit</button>
</form>
<script>
    document.getElementById('queueForm').addEventListener('submit', function(event) {
        var queueNumber = document.getElementById('quenumber').value;
      
        var regText = queueNumber.match(/[a-zA-Z]+/)[0];
   
        var digit = parseInt(queueNumber.match(/\d+/)[0]);
     
        document.getElementById('regtext').value = regText;
        document.getElementById('digit').value = digit;
    });

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

  </div>
  <footer class="footer-container">
  <a href="../index.php">
    <button type="submit" style="background-color: #e3ff37; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer;">Home</button>
  </a>
  </footer>

  
</body>
</html>

