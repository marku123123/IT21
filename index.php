<?php

use Google\Service\Adsense\Header;
session_start();

if (isset($_SESSION['google_login']) || (isset($_SESSION['logged_in']))) {

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="Icon" href="image/halasan-logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style/index.css">

  </head>


  <body>
    <?php
    include 'loader.php';
    include("navbar.php");

    require_once 'database/dbconn.php';
    require_once 'vendor/autoload.php';
    require_once 'database/google_api_config.php';
    require_once 'admin/log_audit.php'; // Include the audit logging function

    //   ------------------------ FOR AUDIT LOG ------------------------------
    if (isset($_SESSION['google_login']) && !isset($_SESSION['google_login_audit_log_inserted'])) {
      // Log the login attempt
      log_audit($_SESSION['google_login']['userID'], 'Login', 'User logged in from Google successfully.');

      // Set the session variable to indicate that the login audit log has been inserted
      $_SESSION['google_login_audit_log_inserted'] = true;
    }


    ?>
    <div class="parent_container">
      <section class="sec1" id="sec1">

        <div class="container" style="margin-top: 100px;">
          <?php
          if (isset($_SESSION['success'])) {
            echo '
                                  <div class="alert alert-success alert-dismissible" role="alert"><strong>' .
              $_SESSION['success'] .
              '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                                  <script>
                                      setTimeout(function() {
                                          document.querySelector(".alert").style.display = "none";
                                      }, 3000); // 3 seconds
                                  </script>
                              ';
            unset($_SESSION['success']);
          }
          ?>
          <div class="row">

            <?php if (isset($_SESSION['google_login'])) { ?>
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <a href="schedule_appointment.php"><button class="Reserve_btn">Schedule an Appointment <i class="fa-solid fa-circle-plus"></i></button></a>
              </div>
            <?php } else if (isset($_SESSION['logged_in'])) { ?>
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <a href="schedule_appointment.php"><button class="Reserve_btn">Schedule an Appointment <i class="fa-solid fa-circle-plus"></i></button></a>
              </div>
            <?php } else { ?>
              <div class="col-md-12 d-flex justify-content-between align-items-center">
                <a href="login.php"><button class="Reserve_btn">Schedule an Appointment <i class="fa-solid fa-circle-plus"></i></button></a>
              </div>
            <?php } ?>
            <?php
            //FOR TESTING
            //echo json_encode($_SESSION['google_login'], JSON_PRETTY_PRINT); 
            ?>

          </div>
          <div class="wrapper">

            <div class="first-wrapper">
              <img src="image/index-image.png" alt="" style="width: 100%;">
            </div>
          </div>

          <?php
          /* -------- TESTING -------- 
        if (isset($_SESSION['google_login'])) {
          echo "Google login " . "ID = " . $_SESSION['google_login']['userID'];
        } else if (isset($_SESSION['logged_in'])) {
          echo "User login " . "ID = " . $_SESSION['logged_in']['userID'];
        }
        */
          ?>
          <div class="homepage_wrapper">
            <div class="d-flex flex-row card-row">
              <div class="card services-card">
                <img src="image/image1.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Dental Services in Davao City</h5>
                  <p class="card-text">We can do all the dental work you need under one roof for very affordable prices. Our Davao dental practice has created beautiful smiles and happy teeth for people for many years.</p>
                  <a href="#" class="btn btn-primary">READ MORE</a>
                </div>
              </div>
              <div class="card services-card">
                <img src="image/image2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Time3 Self-Ligating Bracket</h5>
                  <p class="card-text">Selective engagement allows you to choose the ideal balance between low friction and interactive control for each treatment phase. Early in treatment, with smaller dimension</p>
                  <a href="#" class="btn btn-primary">READ MORE</a>
                </div>
              </div>
              <div class="card services-card">
                <img src="image/image3.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Celebrity Smile: Introducing Zirconia</h5>
                  <p class="card-text">A zirconia crown is a popular type of all-ceramic crown which is worn to improve the appearance of a tooth which has become stained or disfigured over the years.</p>
                  <a href="#" class="btn btn-primary">READ MORE</a>
                </div>
              </div>
            </div>
          </div>

      </section>
      <br>

      <section class="sec2" id="sec2">
        <div class="container" style="margin-top: 20px;">
          <hr>
          <div class="row justify-content-center">
            <div class="col-md-6 abt_img">
              <img src="image/dr-ruel-john-rjay-halasan-dentist-davao.jpg" alt="Dr. Halasan" class="img-fluid">
            </div>
            <div class="col-md-6">
              <div class="about_details">
                <h1 class="about_header">About Dr. Ruel Halasan</h1>
                <p>
                  <br>
                  Dr. Ruel John Halasan is passionate about his profession and responsibility to your family's dental health. For Dr. Ruel it has never been okay to just be an average dentist or to deliver average results- he has always aimed to exceed expectations.
                  <br><br>
                  Dr. Ruel considers in delivering the highest level of dental care with a personal touch to every patient who seeks his help. The team at Halasan Dental Clinic understands that dentistry can be overpowering. Led by Dr. Ruel, everyone on the Halasan Dental team takes the time to understand each patient's point of view and unique dental situation to ensure a comfortable and enjoyable experience.
                  <br>
                  Our mission is to provide students with a convenient and efficient way to book meeting rooms, enabling them to collaborate effectively and achieve their academic and extracurricular goals.
                  <br><br>
                  Dr. Ruel enjoys treating patients of all ages and keeping these friendships for years. His passion is creating an individual plan of dental health that will allow each patient to maintain strong teeth, healthy gums and a beautiful smile for a lifetime. He treats every patient as he would treat his own family members and offers his patients access to his personal cell phone number.
                  <br>

                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!----------------------------------------------------------------------------- MY APPOINTMENTS ----------------------------------------------------------------------->
      <section class="sec3" id="sec3">
        <div class="container">
          <hr>
          <?php
          $stmt = $conn->prepare("SELECT b.*, u.*
                        FROM appointments b 
                        INNER JOIN users u ON b.userID = u.userID 
                        WHERE b.userID = :userID;");

          if (isset($_SESSION['logged_in'])) {
            $userID = $_SESSION['logged_in']['userID'];
          } else if (isset($_SESSION['google_login'])) {
            $userID = $_SESSION['google_login']['userID'];
          }

          if (isset($userID)) {
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }
          // -------------------------------------------  GOOGLE LOGIN END  -------------------------------------------

          ?>
          <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-column">
              <h1>MY APPOINTMENTS</h1>
              <!--
            <div class="d-flex justify-content-end w-100">
              <a href="schedule_appointment.php" class="mt-3 mb-3"><button class="Reserve_btn">Schedule an Appointment<i class="fas fa-plus"></i></button></a>
            </div>
            -->
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Patient name</th>
                  <th>Scheduled Time</th>
                  <th>Appointment Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($results)) : ?>
                  <?php foreach ($results as $row) : ?>
                    <tr>
                      <td><?php echo ($row['patient_name']); ?></td>
                      <td><?php echo date("g:i A", strtotime($row['time_in'])) . " - " . date("g:i A", strtotime($row['time_out'])); ?></td>
                      <td><?php echo date("m-d-Y", strtotime($row['appointment_date'])); ?></td>
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
                <?php else : ?>
                  <tr>
                    <td colspan="4" style="text-align: center;">No records found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!----------------------------------------------------------------------------- MY APPOINTMENTS END ----------------------------------------------------------------------->
      <br>
    </div>
    <?php include("footer.php"); ?>
  </body>

  </html>
<?php } else {
  Header('Location: login.php');
} ?>