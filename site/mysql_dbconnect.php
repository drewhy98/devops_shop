<?php
$servername = getenv('DB_SERVER') ?: 'db';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: 'root';
$database   = getenv('DB_NAME') ?: 'shopdb';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>
