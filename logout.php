<?php
session_start();
require_once 'admin/log_audit.php'; // Include the audit logging function
require_once 'database/google_api_config.php'; // Google API configuration

// Function to log out from Google and revoke the token
function logout_from_google()
{
    global $client;

    try {
        // Revoke Google token if it exists
        if (isset($_SESSION['user_token'])) {
            $client->revokeToken($_SESSION['user_token']);
            unset($_SESSION['user_token']); // Clear the Google token
        }
    } catch (Exception $e) {
        // Handle any issues with revoking the token
        log_audit('unknown', 'Logout Error', 'Error revoking Google token: ' . $e->getMessage());
    }
}
// Log out manually 
if (isset($_SESSION['logged_in'])) {
    $userID = $_SESSION['logged_in']['userID']; // Assuming 'userID' is part of the logged-in user session data

    // Call the Google logout function
    //logout_from_google();
}

// Log out from Google
if (isset($_SESSION['google_login'])) {
    $userID = $_SESSION['google_login']['userID']; // Assuming 'userID' is part of the logged-in user session data

    // Call the Google logout function
    logout_from_google();
}

// Log the logout event
log_audit($userID, 'Logout', 'User logged out successfully.');

// Clear session data and destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
