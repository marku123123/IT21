<?php
session_start();
require_once('../database/dbconn.php');
require_once('../admin/log_audit.php'); // Include the audit logging function

try {
  $sql = "SELECT * FROM users WHERE userID = :tmp_userID";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':tmp_userID', $_GET['userID'], PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  // Access other details like fullname or username
  $full_name = $row['full_name'];

  // Log the view user details event
  if (isset($_SESSION['logged_in'])) {
    $userID = $_SESSION['logged_in']['userID']; // Assuming 'userID' is part of the logged-in user session data
    log_audit($userID, 'Viewed user details', 'Viewed details of user: ' . $full_name . '.');
  }
} catch (PDOException $e) {
  echo "ERROR: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <link rel="stylesheet" href="../style/admin_edit.css">
  <link rel="stylesheet" href="../style/loader.css">
  <title>ADMIN-USER-EDIT</title>
  <style>
    ::placeholder {
      color: #aaa;
      /* change the color to red */
    }
  </style>
</head>


<body style="background-color: #f1f1f1;"><br>

  <?php
  include("../loader.php")
  ?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 p-4 box_center">

        <div class="align_row">
          <a href="admin_manage_users.php"><i class="fas fa-arrow-left"></i></a>
          <h2>UPDATE USER INFORMATION</h2><!-- CHARCOAL COLOR -->
        </div>


        <form action="admin_user_submit.php" method="post">
          <!----------- HIDE userID ----------->
          <div class="mb-3">
            <input style="width: 95%; background: white; margin-bottom: 20px;" type="hidden" name="userID" size="20" value="<?php echo $row['userID']; ?>" readonly>
          </div>

          <div class="mb-3">
            <label for="newfullname">Full Name:</label>
            <input style="width: 95%; background: white; margin-bottom: 20px;" type="text" name="newfullname" size="20" value="<?php echo $row['full_name']; ?>" autocomplete="off" required>
          </div>

          <div class="mb-3">
            <label for="newusername">Username:</label>
            <input onInput="checkUsername()" style="width: 95%; background: white; margin-bottom: 20px;" type="text" name="newusername" size="20" id="newusername" value="<?php echo $row['username']; ?>" required>
            <p id="check-username"></p>
          </div>

          <div class="mb-3">
            <label for="newemail">Email:</label>
            <input style="width: 95%; background: white; margin-bottom: 20px;" type="email" name="newemail" size="20" value="<?php echo !empty($row['email']) ? $row['email'] : ''; ?>" placeholder="<?php echo empty($row['email']) ? 'Add email account.' : ''; ?> "required>
          </div>


          <div class="mb-3">
            <label for="newrole" class="form-label">Role:</label>
            <select id="newrole" name="newrole" class="form-control" style="width: 95%;">
              <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
              <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
          </div>

          <!--
          <div class="mb-3">
            <label for="newmobilenumber">Phone Number:</label>
            <input style="width: 95%; background: white; margin-bottom: 20px;" type="tel" name="newphonenumber" title="It should start with 09 ex. (09123456789)" size="20" id="newphonenumber" inputmode="numeric" pattern="09\d{9}" maxlength="11" value="<?php echo $row['phone_number']; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 13" oninput="checkPhoneNumber()">
            <p id="check-mobile-number"></p>
          </div>
          -->

          <div class="d-flex justify-content-end">
            <!-- PUT SESSION AFTER EDIT -->
            <?php $_SESSION['success'] = "Edited successfully."; ?>

            <button type="submit" class="btn btn_submit">Save Changes</button>
            <a href="admin_manage_users.php">
              <button type="button" class="btn btn_cancel" style="">Cancel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>