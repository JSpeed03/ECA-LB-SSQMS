<?php
$queueNumber = isset($_GET['queueNumber']) ? $_GET['queueNumber'] : 'Unknown';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Queue Number</title>
    <link href="../logo/exact logo - HD.png" rel="icon">
    <link rel="stylesheet" href="TicketStyle.css">
</head>
<body>

    <header>
        <img src="../logo/exact logo - HD.png" alt="ECAlogo">
        <h3>Exact Colleges of Asia</h3>
        <img src="../logo/BSIS.png" alt="ISlogo">
    </header>
    <h1 id="printHeading"><?php echo htmlspecialchars($queueNumber); ?></h1>
    <h2>Thank You for using our system</h2>
    <p id="printParagraph">Developed by: TeamBa</p>
    <div class="button-container">
    </div>
    <footer>
        <a id="newQueueLink" href="../index.html"><button id="newQueueBtn">Home</button></a>
    </footer>

    <script>
        setTimeout(function() {
            document.getElementById("newQueueBtn").click();
        }, 10000);

window.addEventListener('load', function() {

    var heading = document.getElementById('printHeading');

 
    setTimeout(function() {
        var enterEvent = new KeyboardEvent('keydown', {key: 'Enter'});
        document.dispatchEvent(enterEvent);
    }, 1500); 

 
    setTimeout(function() {
        print(heading);
    }, 10); 
});

    </script>
</body>
</html>
