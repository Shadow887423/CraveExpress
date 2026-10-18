<?php
// Backend/db_connect.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_config.php';

$conn = false;
$db_connected = false;

// Attempt sqlsrv connection if extension is loaded
if (function_exists('sqlsrv_connect')) {
    // Suppress warnings to handle errors gracefully
    $conn = @sqlsrv_connect($serverName, $connectionInfo);
    if ($conn !== false) {
        $db_connected = true;
    }
}
?>