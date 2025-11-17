<?php
// Database configuration for InfinityFree
define('DB_HOST', 'sql000.infinityfree.com'); // Replace with your InfinityFree DB host
define('DB_USER', 'epiz_XXXXXXXX'); // Replace with your database username
define('DB_PASS', 'your_password'); // Replace with your database password
define('DB_NAME', 'epiz_XXXXXXXX_ntando'); // Replace with your database name

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store settings
define('STORE_NAME', 'Ntando Store');
define('CURRENCY', 'R'); // South African Rand

session_start();
?>
