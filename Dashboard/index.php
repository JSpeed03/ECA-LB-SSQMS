<?php
// Example using a token stored in a cookie
if (!isset($_COOKIE['auth_token']) || !validateToken($_COOKIE['auth_token'])) {
    header("Location: ../sign-in");
    exit();
}

function validateToken($token) {
    // Your token validation logic
    return true; // or false
}
?>