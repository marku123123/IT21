<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'database/google_api_config.php';
require_once 'database/dbconn.php';
require_once 'admin/log_audit.php'; // Include the audit logging function

// Check if Google API Client Library is loaded
if (!class_exists('Google_Client')) {
    error_log("Error: Google API Client Library not loaded");
    exit();
}

// Create Client Request to access Google API
$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);

$client->addScope("email");
$client->addScope("profile");
//echo "Client created successfully!<br>";

// Authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    echo "Code parameter is set<br>";
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        echo "Token fetched successfully<br>";
        if (isset($token['access_token'])) {
            $client->setAccessToken($token['access_token']);
            echo "Access token set successfully<br>";

            // Get profile info
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email =  $google_account_info->email;
            $name =  $google_account_info->name;
            $picture = $google_account_info->picture;
            $verifiedEmail = $google_account_info->verifiedEmail;
            /*
            $firstName = $google_account_info->givenName;
            $lastName = $google_account_info->familyName;
            */

            echo "Profile info fetched successfully<br>";

            // Check if user exists in database
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetchAll();

            if (count($result) > 0) {
                $logged_in = $result[0]; // ----------------------------------------- IMPORTANT SESSION -----------------------------------------
                $_SESSION['google_login'] = $logged_in;

                // User already exists, update token
                $stmt = $conn->prepare("UPDATE users SET token = :token WHERE email = :email");
                $stmt->bindParam(":token", $token['access_token']);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                echo "User token updated successfully<br>";
            } else {
                // User does not exist, create new user
                $stmt = $conn->prepare("INSERT INTO users (email, first_name, last_name, full_name, picture, verifiedEmail, token) VALUES (:email, :first_name, :last_name, :full_name, :picture, :verifiedEmail, :token)");
                $verifiedEmailStr = (string) $verifiedEmail;

                // Use ucwords to capitalize the first letter of each word in the full_name, first_name, and last_name variables
                $fullName = ucwords($name);
                $firstName = ucwords($firstName);
                $lastName = ucwords($lastName);

                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":first_name", $firstName);
                $stmt->bindParam(":last_name", $lastName);
                $stmt->bindParam(":full_name", $fullName);
                $stmt->bindParam(":picture", $picture);
                $stmt->bindParam(":verifiedEmail", $verifiedEmailStr);
                $stmt->bindParam(":token", $token['access_token']);
                if ($stmt->execute()) {
                    echo "New user created successfully<br>";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error creating new user<br>";
                }
            }
            $conn = null; // Release database connection
            // Set the user token
            $_SESSION['user_token'] = $token['access_token'];

            // Now you can use this profile info to create account in your website and make user logged in.
            header("Location: index.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    //echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}
