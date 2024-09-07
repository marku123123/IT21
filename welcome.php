<?php
/* ------------------------------------------------------------------------ FOR TESTING  ------------------------------------------------------------------------ */
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'database/google_api_config.php';
require_once 'database/dbconn.php';

// Check if user token is set
if (!isset($_SESSION['user_token'])) {
  header("Location: login.php");
  exit();
}

// Connect to database
$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$conn) {
  error_log("Error: " . mysqli_connect_error());
  exit();
}

// Check if user exists in database
$stmt = $conn->prepare("SELECT * FROM users WHERE token =?");
$stmt->bind_param("s", $_SESSION['user_token']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $userinfo = $result->fetch_assoc();

  //store info in session
  $_SESSION['userinfo'] = $userinfo;
} else {
  // User does not exist, create new user
  $stmt = $conn->prepare("INSERT INTO users (email, first_name, last_name, full_name, picture, verifiedEmail, token) VALUES (?,?,?,?,?,?,?)");
  $verifiedEmailStr = (string) $verifiedEmail;

  $stmt->bind_param("sssssss", $email, $firstName, $lastName, $name, $picture, $verifiedEmailStr, $token['access_token']);
  $stmt->execute();
  echo "New user created successfully<br>";
}

$conn->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link rel="icon" type="image/png" href="image/halasan-logo.jpg"> <!-- Add a favicon -->
</head>

<body>
  <?php if (isset($_SESSION['userinfo'])) : ?>
    <?php if (isset($_SESSION['userinfo']['picture'])) : ?>
      <img src="<?php echo htmlspecialchars($_SESSION['userinfo']['picture']); ?>" alt="" width="90px" height="90px">
    <?php endif; ?>
    <ul>

      <!-- <li>Token: <?php echo htmlspecialchars($_SESSION['user_token']); ?></li> -->

      <?php if (isset($_SESSION['userinfo']['full_name'])) : ?>
        <li>Full Name: <?php echo htmlspecialchars($_SESSION['userinfo']['full_name']); ?></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['userinfo']['email'])) : ?>
        <li>Email Address: <?php echo htmlspecialchars($_SESSION['userinfo']['email']); ?></li>
      <?php endif; ?>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  <?php endif; ?>
</body>

</html>