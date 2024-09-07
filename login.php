<?php
session_start();
require_once 'database/google_api_config.php'; // Ensure this file includes Google API setup
require_once 'database/dbconn.php'; // Database connection file
require_once 'admin/log_audit.php'; // Include the audit logging function

// Check if user is already authenticated
if (isset($_SESSION['user_token'])) {
    header("Location: index.php");
    exit();
}

// Handle Google authentication flow
if (isset($_GET['code'])) {
    try {
        // Exchange authorization code for access token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['access_token'])) {
            $_SESSION['user_token'] = $token['access_token'];

            // Retrieve user profile information from Google
            $oauth = new Google_Service_Oauth2($client);
            $userInfo = $oauth->userinfo->get();
            $userID = $userInfo->id;
            $userEmail = $userInfo->email;

            // Log the Google login event
            log_audit($userID, 'Login', 'User logged in with Google email: ' . $userEmail);

            header("Location: welcome.php");
            exit();
        } else {
            // Log failed login attempt
            log_audit(0, 'Login Failed', 'Failed to receive access token.');
            echo "Error: No access token received";
            exit();
        }
    } catch (Exception $e) {
        // Log the exception
        log_audit(0, 'Login Failed', 'Exception occurred: ' . $e->getMessage());
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="Icon" href="image/halasan-logo.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="style/login.css">
    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="text" style="text-align: center;">
                        <!-- Optional content here -->
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '
                                <div class="alert alert-danger alert-dismissible" style="" role="alert">
                                <strong>' . htmlspecialchars($_SESSION['error']) .
                                '</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <script>
                                    setTimeout(function() {
                                        document.querySelector(".alert").style.display = "none";
                                    }, 3000); // 3 seconds
                                </script>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['signup_success'])) {
                            echo '
                                <div class="alert alert-success alert-dismissible" style="" role="alert">
                                    <strong>' . htmlspecialchars($_SESSION['signup_success']) .
                                '</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <script>
                                    setTimeout(function() {
                                        document.querySelector(".alert").style.display = "none";
                                    }, 3000); // 3 seconds
                                </script>';
                            unset($_SESSION['signup_success']);
                        }
                        ?>

                        <header>Login Account</header>
                        <form action="login_submit.php" method="POST">
                            <div class="input-field">
                                <input type="text" class="input" id="username" title="Please enter your username" required autocomplete="off" name="username" autofocus>
                                <label for="username">Username </label>
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" id="password" title="Please enter your password" name="password" required>
                                <label for="password">Password</label>
                                <span class="eye-icon" id="togglePassword">
                                    <i class="fa-solid fa-eye" id="eye-icon"></i>
                                    <i class="fa-solid fa-eye-slash" id="eye-slash-icon"></i>
                                </span>
                            </div>
                            <script>
                                const passwordInput = document.getElementById('password');
                                const togglePassword = document.getElementById('togglePassword');
                                const eyeIcon = document.getElementById('eye-icon');
                                const eyeSlashIcon = document.getElementById('eye-slash-icon');

                                togglePassword.addEventListener('click', function() {
                                    if (passwordInput.type === 'password') {
                                        passwordInput.type = 'text';
                                        eyeIcon.style.display = 'none';
                                        eyeSlashIcon.style.display = 'block';
                                    } else {
                                        passwordInput.type = 'password';
                                        eyeIcon.style.display = 'block';
                                        eyeSlashIcon.style.display = 'none';
                                    }
                                });
                                // Hide the eye-slash icon initially
                                eyeSlashIcon.style.display = 'none';
                            </script>

                            <div class="input-field">
                                <input type="submit" class="submit" value="Login" name="logged_in">
                            </div>
                            <div class="signin">
                                <span>Don't have an account yet? <a href="register.php" class="register-link">Register here</a></span><br>
                                <hr>
                                <span class=""><a href="<?php echo $client->createAuthUrl() ?>"><img src="image/google-signin-button.png" height="60" width="250;"></a></span><br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>