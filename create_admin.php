<?php
require_once 'database/dbconn.php';

$username = 'admin'; // Replace with your desired admin username
$password = 'admin'; // Replace with your desired admin password
$full_name = 'admin';
$role = 'admin'; // Set the role to 'admin'

// Check if the admin username already exists
$query = "SELECT * FROM users WHERE username = :username";
$statement = $conn->prepare($query);
$statement->execute(['username' => $username]);

// If the username doesn't exist, insert the admin account into the database
if ($statement->rowCount() == 0) {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4]);

    // Insert the admin account into the database
    $query = "INSERT INTO users (username, password,full_name, role) VALUES (:username, :password,:full_name, :role)";
    $statement = $conn->prepare($query);
    $statement->execute([
        'username' => $username,
        'password' => $hashed_password,
        'full_name' => $full_name,
        'role' => $role
    ]);

    echo "Admin account created successfully!";
} else {
    echo "Admin account already exists!";
}
