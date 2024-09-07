<?php
if (!isset($_SESSION)) {
  session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  // Redirect to the login page
  header('Location: ../login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN-MANAGE-APPOINTMENTS</title>
  <link rel="Icon" href="../image/halasan-logo.png" type="image/x-icon">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEG1ydZ+gk5BdPtF+to8xM6B5z6W5yZXFzryanM8oSTw==" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="../style/loader.css">
  <link rel="stylesheet" href="../style/admin.css">
  <link rel="stylesheet" href="../style/footer.css">
  <!-- PARA NI SA NAV-LINK -->
  <script defer src="active_link.js"></script>
</head>


<body>

  <?php
  include '../loader.php';
  require_once '../database/dbconn.php';
  include 'admin_navbar.php';

  $stmt = $conn->prepare("SELECT b.*, u.*
                        FROM appointments b 
                        INNER JOIN users u ON b.userID = u.userID 
                        ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <br>


  <div class="container">


    <h1 style="margin-top: 100px;">APPOINTMENTS</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Reserved by</th>
            <th>Patient name</th>
            <th>Date</th>
            <th>Schedule time</th>
            <th>Status</th>
            <th style="text-align:center;">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($results)) : ?>
          <?php foreach ($results as $row) : ?>
            <tr>
              <td><?php echo ucfirst($row['full_name']); ?></td>
              <td><?php echo ($row['patient_name']); ?></td>
              <td><?php echo date("m-d-Y", strtotime($row['appointment_date'])); ?></td>
              <td><?php echo date("g:i A", strtotime($row['time_in'])) . " - " . date("g:i A", strtotime($row['time_out'])) ?></td>
              <td style="color: <?php echo ($row['status'] == 'Approved') ? 'green' : (($row['status'] == 'Denied') ? 'red' : '#ccc'); ?>; font-weight: 600;">
                <?php echo ($row['status']); ?>
              </td>
              <td class="text-center">
                <a href="admin_manage_appointments_submit.php?bookingID=<?= $row['bookingID']; ?>&action=Approved" class="btn btn-success btn-sm">
                  <i class="fas fa-check"></i>
                </a>
                <a href="admin_manage_appointments_submit.php?bookingID=<?= $row['bookingID']; ?>&action=Denied" class="btn btn-danger btn-sm">
                  <i class="fas fa-ban"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" style="text-align: center;">No results found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <br><br><br><br><br><br><br><br><br><br>

  <?php
  include("admin_footer.php");
  ?>
</body>


<script>
  function promptLogin() {
    Swal.fire({
      icon: 'warning',
      title: 'Sorry',
      text: 'You need to login first!',
      showCancelButton: true,
      confirmButtonText: 'Login',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "login.php";
      }
    });
  }
</script>

</html>