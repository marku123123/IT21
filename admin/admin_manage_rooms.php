<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN-MANAGE-ROOMS</title>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


  <link rel="stylesheet" href="style/admindesign.css">
  <script defer src="active_link.js"></script>

  <style>
    .custom-confirm-btn {
      font-size: 18px;
      padding: 10px 20px;
      border-radius: 5px;
      background-color: rebeccapurple;
      color: #ffffff;
      width: 100px;
      margin-right: 5px;
      border: none;
    }

    .custom-cancel-btn {
      font-size: 18px;
      padding: 10px 20px;
      border-radius: 5px;
      background-color: #cccccc;
      color: #333333;
      width: 100px;
      border: none;
    }
  </style>
</head>

<body>

  <?php
  include("loader.php");
  include('admin_navbar.php');

  if (isset($_SESSION["savedChanges"])) {
    if ($_SESSION["savedChanges"] === "savedChanges") {
      // Display a success message
      echo '<div class="alert alert-success">Saved Changes</div>';
      unset($_SESSION["savedChanges"]); // Remove the session variable after use
    }
  }

  ?>
  <br><br><br><br><br><br>



  <div class="container">
    <div class="row">
      <section class="intro">
        <div class="bg-image h-100" style="background-color: transparent;">
          <div class="mask d-flex align-items-center h-100">
            <div class="container">
              <div class="row">
                <div class="table-responsive">
                  <div class="d-flex justify-content-between align-items-center mb-3 add-room">
                    <h1 class="mb-0">ROOMS</h1>
                    <button type="button" class="btn" onclick="location.href='admin_add_rooms.php';">
                      <i class="bi bi-plus-circle icon"></i> ADD ROOM
                    </button>
                  </div>

                  <div class="col-12">

                    <div class="card">

                      <div class="card-body">

                        <div class="table-responsive" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px;">
                          <table class="table table-striped table-hover mb-0">
                            <thead class="">

                              <tr>
                                <th class="text-center align-middle" scope="col">Room Profile</th>
                                <th class="text-center align-middle" scope="col">Room Name</th>
                                <th class="text-center align-middle" scope="col">No. of rooms</th>
                                <th class="text-center align-middle" scope="col">Status</th>
                                <th class="text-center align-middle" scope="col">Capacity</th>
                                <th class="text-center align-middle" scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              require_once('database/dbconn.php');
                              try {
                                $stmt = $conn->prepare("SELECT * FROM rooms");
                                $stmt->execute();
                                foreach ($stmt->fetchAll() as $row) {
                              ?>
                                  <tr>
                                    <td class="text-center">
                                      <?php
                                      // output the image as data URI
                                      $img_data = base64_encode($row['room_profile']);
                                      $img_type = 'image/jpeg'; // replace with the appropriate image type
                                      ?>
                                      <img src="data:<?php echo $img_type; ?>;base64,<?php echo $img_data; ?>" width="250" height="200">
                                    </td>
                                    <td class="text-center align-middle"><?php echo $row['room_name']; ?></td>
                                    <td class="text-center align-middle"><?php echo $row['room_quantity']; ?></td>
                                    <td class="text-center align-middle"><?php echo $row['status']; ?></td>
                                    <td class="text-center align-middle"><?php echo $row['room_capacity']; ?></td>
                                    <td class="text-center align-middle"> <a href="admin_rooms_edit.php?roomID=<?php echo $row['roomID']; ?>" class="me-3 text-decoration-none">
                                        <i class="fas fa-edit" style="color:rebeccapurple; font-size: 24px;"></i></a>
                                      <!--
                                      <a href="#" onclick="showConfirmation('<?php echo $row['roomID']; ?>')"><i class="fas fa-trash-alt text-danger" style="font-size: 24px;"></i> </a>
                                      -->
                                    </td>
                                  </tr>
                              <?php
                                }
                              } catch (PDOException $e) {
                                echo "ERROR: " . $e->getMessage();
                              }
                              $conn = null;
                              ?>
                            </tbody>

                            <script>
                              function showConfirmation(roomID) {
                                Swal.fire({
                                  title: 'Are you sure you want to delete this?',
                                  text: 'Once you agree, you cannot undo this anymore.',
                                  icon: 'warning',
                                  showCancelButton: true,
                                  confirmButtonText: 'Yes',
                                  cancelButtonText: 'Cancel',
                                  buttonsStyling: false,
                                  confirmButtonClass: 'custom-confirm-btn',
                                  cancelButtonClass: 'custom-cancel-btn',
                                  customClass: {
                                    confirmButton: 'custom-confirm-btn',
                                    cancelButton: 'custom-cancel-btn'
                                  },
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    window.location.href = 'admin_rooms_delete.php?roomID=' + roomID + '&confirm_delete=yes';
                                  }
                                })
                              }
                            </script>

                            <script>

                            </script>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>

</html>