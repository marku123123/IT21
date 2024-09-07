<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN-NAVBAR</title>
    <link rel="Icon" href="../image/halasan-logo.jpg" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/navbar.css">
</head>

<body>

    <div class="fixed-top">
        <div class="container" style="background-color: white;">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar color" style="background-color: white;">
                    <a class="navbar-brand me-2" href="../admin/admin_home.php">
                        <img class="nav-img" src="../image/halasan-logo.jpg" loading="lazy" style="cursor: pointer;" />
                        <p class="nav">Halasan Dental Clinic 2.0</p>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#micon">
                        <span class="navbar-toggler-icon"> <i class="fas fa-bars fa-lg"></i></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="micon">
                        <ul class="navbar-nav mb-2 mb-lg-0">

                            <li class="nav-item text">
                                <a class="nav-link custom_link" aria-current="page" id="manage_users" href="admin_manage_users.php">Manage Users</a>
                            </li>

                            <li class="nav-item text">
                                <a class="nav-link custom_link" aria-current="page" id="manage_bookings" href="admin_manage_appointments.php">Manage Appointments</a>
                            </li>

                            <li class="nav-item text">
                                <a class="nav-link custom_link" aria-current="page" id="manage_audits" href="view_audit_logs.php">View Audit Logs</a>
                            </li>
                        </ul>
                    </div>

                    <!-- For larger screens    -->
                    <div class="d-none d-lg-flex ml-auto align-items-center">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                                Admin Panel
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="admin_home.php">Home</a></li>

                                <li><a class="dropdown-item" style="cursor: pointer;" onclick="confirmLogout()">Logout</a></li>
                            </ul>
                        </div>
                    </div>

                </nav>
            </div>
        </div>
    </div>


    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Do you really wish to log out?',
                text: "This will sign you out and needs you to login again.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#0096FF',
                cancelButtonText: 'Cancel'

            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../logout.php"
                }
            });
        }
    </script>
</body>


</html>