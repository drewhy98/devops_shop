<?php
$serverName = "YOUR_SERVER_NAME";   // PLACEHOLDER details
$connectionOptions = array(
    "Database" => "Shopusers",
    "Uid" => "YOUR_DB_USERNAME",
    "PWD" => "YOUR_DB_PASSWORD"
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
