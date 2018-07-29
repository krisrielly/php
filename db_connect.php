<?php

// default to localhost values
$host = "localhost";
$port = "3306";
$user = "root";
$pw = "root";
$dbname = "ecommerce";

// if we're on the PBCS server, use the cloud account values
if (gethostname() == "server.pbcs.us") {
    $host = 'localhost';
    $port = '3306';
    $user = 'CPANEL_USERNAME';
    $pw = 'CPANEL_PASSWORD';
    $dbname = $user . '_' . 'DATABASENAME';
}

$connection_info =
    "mysql"
    . ": host=" . $host
    . ": " . $port
    . "; dbname=" . $dbname
;

try {
    $db = new PDO($connection_info, $user, $pw);
} catch (PDOException $e) {
    echo $e->getMessage();
    echo "host:port = $host:$port";
    echo "dbname = $dbname";
    echo "user = $user";
    exit();
}
