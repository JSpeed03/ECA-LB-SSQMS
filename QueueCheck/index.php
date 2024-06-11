<?php
require '../DBConn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
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
</script>

  </div>
  <footer class="footer-container">
    <a href="../index.html">back</a>
  </footer>

  
</body>
</html>

