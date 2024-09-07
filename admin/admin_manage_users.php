<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN-MANAGE-USERS</title>
  <link rel="Icon" href="../image/halasan-logo.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="../style/loader.css">
  <link rel="stylesheet" href="../style/admin.css">
  <link rel="stylesheet" href="../style/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <script defer src="active_link.js"></script>
</head>

<body>
  <?php
  session_start();
  include '../loader.php';
  require_once '../database/dbconn.php';
  include 'admin_navbar.php';

  try {
    $stmt = $conn->prepare("SELECT * FROM users");
  //$stmt = $conn->prepare("SELECT users.*, appointments.* FROM users JOIN appointments ON users.userId = appointments.userId");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
    <br>
    <div class="container">
      <h1 style="margin-top: 100px;">USERS</h1>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th class="text-center" scope="col">No.</th>
              <th class="text-center" scope="col">Username</th>
              <th class="text-center" scope="col">Email</th>
              <th class="text-center" scope="col">Role</th>
              <th class="text-center" scope="col">Full name</th>
              <th class="text-center" scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($results as $row) : { ?>
                <tr>
                <td class="text-center"><?= $row['userID']; ?></td>
                  <td class="text-center"><?= $row['username']; ?></td>
                  <td class="text-center" style="<?= empty($row['email']) ? 'color: #ccc;' : ''; ?>"><?= !empty($row['email']) ? $row['email'] : '<span style="color: #ccc;">Email not connected.</span>'; ?></td>
                  <td class="text-center"><?= ucwords($row['role']); ?></td>
                  <td class="text-center"><?= $row['full_name']; ?></td>
                  <td class="text-center">
                    <a href="admin_user_edit.php?userID=<?= $row['userID']; ?>" class="btn btn-edit btn-sm">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                  </td>
                </tr>
          <?php }
            endforeach;
          } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
          }
          /*
          if (isset($_SESSION['success'])) {
            echo '
            <div class="alert alert-light text-success alert-dismissible" role="alert"><strong>' .
              $_SESSION['success'] .
              '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector(".alert").style.display = "none";
                }, 3000); // 3 seconds
            </script>';
            unset($_SESSION['success']);
          }
            */
          ?>

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