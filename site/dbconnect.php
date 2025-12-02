<?php
$servername = getenv('DB_SERVER') ?: 'db';
$username   = getenv('DB_USER')   ?: 'root';
$password   = getenv('DB_PASS')   ?: 'root';
$database   = getenv('DB_NAME')   ?: 'shopdb';

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}
?>
