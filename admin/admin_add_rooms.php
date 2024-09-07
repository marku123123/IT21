<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN-ADD-ROOMS</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="navbardesign/admindesign.css">
  <link rel="stylesheet" href="navbardesign/tabledesign.css">

  <script defer src="active_link.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>

<body>
  <br><br>
  <div class="container">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6 p-4" style="border: 2px solid rebeccapurple;">
          <h2 style="text-align: center; font-weight: bold; color:#36454F;">ADD ROOMS</h2><br>

          <form action="admin_add_rooms_submit.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="room_name" class="form-label">Room Name:</label>
              <input type="text" id="room_name" name="room_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="room_quantity" class="form-label">Quantity: (No. of rooms)</label>
              <input type="number" id="room_quantity" name="room_quantity" class="form-control" required min="1" value="1">
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status:</label>
              <select id="status" name="status" class="form-control" required>
                <option value="Available">Available</option>
                <option value="Not available">Not available</option>
                <!-- Add more options as needed -->
              </select>
            </div>
            <div class="mb-3">
              <label for="room_capacity" class="form-label">Maximum capacity: (No. of persons)</label>
              <input type="number" id="room_capacity" name="room_capacity" class="form-control" required min="1" value="">
            </div>
            <div class="mb-3">
              <label for="room_profile" class="form-label">Room Image:</label>
              <input type="file" id="room_profile" name="room_profile" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn" style="width: 150px; background-color:rebeccapurple; color:white; margin-right:5px;">Submit</button>
              <a href="admin_manage_rooms.php">
                <button type="button" class="btn" style="width: 150px; background-color: #36454F; color:white;"><i class="fas fa-arrow-left" style="text-align:center; margin-right:10px;"></i>Go Back</button>
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
</body>

</html>