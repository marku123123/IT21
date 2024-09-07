<?php
session_start();
require_once 'database/dbconn.php';
require_once 'admin/log_audit.php'; // Include the audit logging function
try {
    if (isset($_POST["logged_in"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate input
        if (empty($username) || empty($password)) {
            $_SESSION["error"] = "All fields are required!";
            header("location:login.php");
            exit;
        }

        // Fetch user data from the database
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $conn->prepare($query);
        $statement->execute(['username' => $username]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION["error"] = "Invalid credentials!";
            header("location:login.php");
            exit;
        }

        // Verify the password
        if (!password_verify($password, $user['password'])) {
            $_SESSION["error"] = "Invalid credentials!";
            header("location:login.php");
            exit;
        }

        // Login successful
        $_SESSION['logged_in'] = $user;
        $_SESSION["success"] = "Logged in successfully!";

        // Log the login attempt
        log_audit($user['userID'], 'Login', 'User logged in successfully.');

        // Set the redirect path based on user role
        if ($user['role'] == 'admin') {
            $_SESSION['redirect'] = "admin/admin_home.php";
        } elseif ($user['role'] == 'user') {
            $_SESSION['redirect'] = "index.php";
        } else {
            $_SESSION['redirect'] = "login.php";
        }

        header("location:" . $_SESSION['redirect']);
        exit;
    }
} catch (PDOException $e) {
    $_SESSION["error"] = "Database connection error: " . $e->getMessage();
    header("location:login.php");
    exit;
}

$conn = null;
