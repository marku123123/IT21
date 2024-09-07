<?php
// Determine the correct path to dbconn.php dynamically
// Check if we're running from the 'admin' folder or other locations
if (file_exists(__DIR__ . '/../database/dbconn.php')) {
    require_once __DIR__ . '/../database/dbconn.php'; // Path to dbconn.php from admin folder
} else {
    require_once __DIR__ . '/../../database/dbconn.php'; // Path to dbconn.php from other folders
}

function log_audit($userID, $action, $details)
{
    global $conn;
    // Set the timezone to Asia/Manila
    date_default_timezone_set("Asia/Manila");

    $timestamp = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO audit_log (user_id, action, details, timestamp) VALUES (:user_id, :action, :details, :timestamp)");
    $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->bindParam(':details', $details, PDO::PARAM_STR);
    $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

    $stmt->execute();
}
