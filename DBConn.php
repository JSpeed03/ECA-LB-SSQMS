<?php
$host = 'localhost'; //change localhost into IP of server

$user = 'QMS';
$password = 'EXCELLENCE2024';
$database = 'eca-lb_ssqms_v2';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
