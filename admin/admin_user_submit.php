<?php
session_start();
require_once '../database/dbconn.php';
require_once '../admin/log_audit.php'; // Include the audit logging function

// Get the posted values
$userID = $_POST['userID'];
$newfullname = $_POST['newfullname'];
$newusername = $_POST['newusername'];
$newemail = $_POST['newemail'];
$newrole = $_POST['newrole'];

//$newphonenumber = $_POST['newphonenumber'];

/* Validate phone number
if (empty($newphonenumber)) {
    ?>
     <script>
         alert("Some fields are empty!");
         window.location.href = "admin_manage_users.php";
     </script>
     <?php
     exit; // Stop executing the script
 }
*/
  



try {
    $sql = "UPDATE users SET full_name = :newfullname, username = :newusername, email = :newemail, role = :newrole WHERE userID = :userID";
    $stmt = $conn->prepare($sql);

    // Bind the parameters correctly
    $stmt->bindParam(':newfullname', $newfullname, PDO::PARAM_STR);
    $stmt->bindParam(':newusername', $newusername, PDO::PARAM_STR);
    $stmt->bindParam(':newemail', $newemail, PDO::PARAM_STR);
    $stmt->bindParam(':newrole', $newrole, PDO::PARAM_STR);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Get the updated user's full name
    $sql = "SELECT full_name FROM users WHERE userID = :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $full_name = $row['full_name'];

    // Log the user update event
    if (isset($_SESSION['logged_in'])) {
        $adminID = $_SESSION['logged_in']['userID']; // Assuming 'userID' is part of the logged-in user session data
        log_audit($adminID, 'User updated', 'Updated user: ' . $full_name . ' with new details.');
    }

    // Redirect to the manage users page after the update
    header('Location: admin_manage_users.php');
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

?>