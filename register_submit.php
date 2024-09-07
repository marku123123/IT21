<?php
session_start();
require_once('database/dbconn.php');
require_once 'admin/log_audit.php'; // Include the audit logging function

// GET VALUES AFTER SUBMIT
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$address = $_POST['address'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

$role = "user";
$picture = "image/Default_pfp.jpg";
$errors = array();

$full_name = ucwords(strtolower($full_name));
$address = ucwords(strtolower($address));


if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

if ($password != $confirmpassword) {
    $errors[] = "Password and confirm password do not match.";
}

// Check if username already exists
$sql = "SELECT 1 FROM users WHERE username=:username";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->fetchColumn() > 0) {
    $errors[] = "Username already exists. Please choose a different one.";
}

if (empty($errors)) {
    // Hash the password using Argon2ID
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4]);

    $query = "INSERT INTO users (username, full_name, address, password, role, picture) 
              VALUES (:username, :full_name, :address, :password, :role, :picture)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);    // Use $hashed_password for the hashed password
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);

    $stmt->execute();

    // Fetch the user ID of the newly registered user
    $userID = $conn->lastInsertId();

    // Log the registration
    log_audit($userID, 'Register', 'User registered successfully.');

    $_SESSION['signup_success'] = "Sign Up Successful.";
    header('Location: login.php');
    exit;
} else {
    $_SESSION['errors'] = $errors;
    header('Location: register.php');
    exit;
}

$conn = null;
