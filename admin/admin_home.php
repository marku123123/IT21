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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN-HOME</title>
  <link rel="Icon" href="../image/halasan-logo.jpg" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="../style/admin.css">
  <link rel="stylesheet" href="../style/loader.css">
  <script defer src="active_link.js"></script>
</head>

<body>
  <?php
  include("../loader.php");
  include('admin_navbar.php');
  ?>
  <br><br><br><br><br>
  <div class="dashboard-header">
    <h1>DASHBOARD</h1>
  </div>
  <br>


  <?php
  require_once('../database/dbconn.php');

  //COUNT USERS
  $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $count = $result['count'];
  ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-person"></i>USERS</h6>
            <?php echo $count; ?>
          </div>
        </div>
      </div>

      <?php
        //COUNT APPOINTMENTS
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM appointments");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
      ?>

      <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-calendar-event"></i> APPOINTMENTS</h6>
            <?php echo $count; ?>
          </div>
        </div>
      </div>



      <div class="container">
        <h1>MANAGE USERS</h1>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-sm">
                    <thead style="background-color: #9A4444;">
                      <tr>
                        <th class="text-center" scope="col">Username</th>
                        <th class="text-center" scope="col">Phone Number</th>
                        <th class="text-center" scope="col">Address</th>
                        <th class="text-center" scope="col">Role</th>
                        <th class="text-center" scope="col">Full Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      try {
                        $stmt = $conn->prepare("SELECT * FROM users");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      ?>
                          <tr>
                            <td class="text-center"> <?php echo $row['username']; ?></td>
                            <td class="text-center"> <?php echo $row['phone_number']; ?></td>
                            <td class="text-center"> <?php echo $row['address']; ?></td>
                            <td class="text-center"> <?php echo ucfirst($row['role']); ?></td>
                            <td class="text-center"> <?php echo $row['full_name']; ?></td>
                          </tr>
                      <?php
                        }
                      } catch (PDOException $e) {
                        echo "ERROR: " . $e->getMessage();
                      }

                      $conn = null;
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <br><br>

      <div class="container">
        <?php
        try {
          $conn = new PDO("mysql:host=localhost;dbname=it21", "root", "");
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("SELECT a.*, u.*, u.userID 
                          FROM appointments a 
                          INNER JOIN users u ON a.userID = u.userID 
                          ");
          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          echo "ERROR: " . $e->getMessage();
        }
        $conn = null;
        ?>

        <div class="container">
          <h1>MANAGE APPOINTMENTS</h1>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Reservation by:</th>
                  <th>Date of appointments</th>
                  <th>Scheduled Time</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
         
                <?php
                 if (!empty($results)) : 
                  foreach ($results as $row) : ?>
                  <tr>
                    <td><?php echo ($row['full_name']); ?></td>
                    <td><?php echo date("m-d-Y", strtotime($row['appointment_date'])); ?></td>
                    <td><?php echo date("g:i A", strtotime($row['time_in'])) . " - " . date("g:i A", strtotime($row['time_out'])) ?></td>
                    <td><?php echo ($row['status']); ?></td>
                    
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
  
        <?php 
        require_once('../database/dbconn.php');
        try {
            $conn = new PDO("mysql:host=localhost;dbname=it21", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT audit_log.*, users.full_name 
                                    FROM audit_log 
                                    JOIN users ON audit_log.user_id = users.userID 
                                    ORDER BY audit_log.id DESC");
            $stmt->execute();
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<div class='container mt-5 alert alert-danger'>ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
            $logs = []; // Set logs to an empty array in case of error
        }
        ?>
        <div class="container mt-5">
            <h1 style="">AUDIT LOGS</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User Full Name</th>
                        <th scope="col">Action</th>
                        <th scope="col">Details</th>
                        <th scope="col">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)) : ?>
                        <tr>
                            <td colspan="5" class="text-center">No logs found.</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        // Set the timezone to Asia/Manila
                        date_default_timezone_set("Asia/Manila");
                        ?>
                        <?php foreach ($logs as $log) : ?>
                            <tr>
                                <td><?= htmlspecialchars($log['id']); ?></td>
                                <td><?= htmlspecialchars($log['full_name']); ?></td>
                                <td><?= htmlspecialchars($log['action']); ?></td>
                                <td><?= htmlspecialchars($log['details']); ?></td>

                                <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($log['timestamp']))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        </div>

    
</body>

</html>