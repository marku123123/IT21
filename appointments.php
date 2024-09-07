<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEG1ydZ+gk5BdPtF+to8xM6B5z6W5yZXFzryanM8oSTw==" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="style/index.css">
  <style>
    body {
      font-family: 'Libre Franklin', sans-serif;
    }
  </style>
</head>

<body>
  <?php
  if (!isset($_SESSION)) {
    session_start();
  }
  require_once('database/dbconn.php');
  include 'navbar.php';
  include 'loader.php';

  if (isset($_SESSION['google_login'])) {
    $userID = $_SESSION['google_login']['userID'];
    $stmt = $conn->prepare("SELECT b.*, u.*
                        FROM appointments b 
                        INNER JOIN users u ON b.userID = u.userID 
                        WHERE b.userID = :userID;");
    $stmt->bindParam(':userID', $_SESSION['google_login']['userID']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // -------------------------------------------  GOOGLE LOGIN END  -------------------------------------------
  } else if (isset($_SESSION['logged_in'])) {
    $userID = $_SESSION['logged_in']['userID'];
    $stmt = $conn->prepare("SELECT b.*, u.*
                        FROM appointments b 
                        INNER JOIN users u ON b.userID = u.userID 
                        WHERE b.userID = :userID;");
    $stmt->bindParam(':userID', $_SESSION['google_login']['userID']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  ?>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-12 d-flex justify-content-between align-items-center flex-column">
        <h1 style="margin-top: 100px;">MY APPOINTMENTS</h1>
        <div class="d-flex justify-content-end w-100">
          <a href="schedule_appointment.php" class="mt-3 mb-3"><button class="Reserve_btn">Schedule an Appointment<i class="fas fa-plus"></i></button></a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Time of Use</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $row) : ?>
            <tr>
              <td><?php echo date("m-d-Y", strtotime($row['appointment_date'])); ?></td>
              <td><?php echo date("g:i A", strtotime($row['time_in'])) . " - " . date("g:i A", strtotime($row['time_out'])); ?></td>
              <td style="color: <?php
                                $statusColor = 'grey';
                                if (isset($row['status'])) {
                                  switch ($row['status']) {
                                    case 'Approved':
                                      $statusColor = 'green';
                                      break;
                                    case 'Denied':
                                      $statusColor = 'red';
                                      break;
                                  }
                                }
                                echo $statusColor;
                                ?>; font-weight: 600;">
                <?php echo htmlspecialchars($row['status']); ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <br><br><br><br><br><br><br><br><br><br>

  <?php
  include("footer.php");
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