<?php
// Change this to your desired password
$password = "123";

// Generate hashed password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Output
echo "Plain Password: " . $password . "<br>";
echo "Hashed Password: " . $hashedPassword;
?>
