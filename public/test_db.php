<?php

$serverName = "localhost, 1434";
$connectionOptions = array(
    "Database" => "Akwaaba360",
    "Uid" => "sa",
    "PWD" => "Akwaaba360Password2024",
    "Encrypt" => false,
    "TrustServerCertificate" => true
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Connection established successfully!";
}

sqlsrv_close($conn);
?>
