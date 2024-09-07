<?php

// MYSQLI Database configuration
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'it21');

$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$conn) {
    error_log("Error: " . mysqli_connect_error());
    exit();
} else {
    //echo "Database Connected Successfully!<br>";
}
