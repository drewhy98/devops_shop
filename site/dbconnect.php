<?php
$servername = 'database-1.cxi46escotxu.eu-north-1.rds.amazonaws.com';  // RDS endpoint
$username   = 'admin';        // your RDS master username
$password   = 'admin123';   // your RDS master password
$database   = 'shopdb';       // your database name

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>
