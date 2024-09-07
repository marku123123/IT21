<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVBAR</title>
    <link rel="Icon" href="../image/halasan-logo.jpg" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style/navbar.css">
</head>

<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<body>
    <div class="fixed-top">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar color" style="background-color: white;">
                    <a class="navbar-brand me-2" href="index.php">
                        <img class="nav-img" src="image/halasan-logo.jpg" loading="lazy" style="cursor: pointer;" />
                        <p class="nav">Halasan Dental Clinic 2.0</p>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#micon">
                        <span class="navbar-toggler-icon"> <i class="fas fa-bars fa-lg toggler"></i></span>
                    </button>

                    <!-- MAO NING NASA CENTER SA NAVBAR -->
                    <div class="collapse navbar-collapse justify-content-center" id="micon">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item text">
                                <a class="nav-link custom_link" aria-current="page" id="homeLink" href="index.php#top">Home</a>
                            </li>
                            <li class="nav-item text">
                                <a class="nav-link custom_link" aria-current="page" id="appointmnentsLink" href="index.php#sec3">Appointments</a>
                            </li>
                        </ul>

                        <!------------------------------------------------------------- For SMALLER SCREENS ------------------------------------------------------------->
                        <div class=" d-flex ml-auto d-lg-none">
                            <?php
                            if (!isset($_SESSION['logged_in'])) {
                            ?>
                                <a href="login.php" class="ml-2">
                                    <button type="button" class="login_btn">Please Login</button>
                                </a>
                            <?php } elseif (isset($_SESSION['logged_in'])) { ?> <!---------------------------------------- Using login form ------------------------------->
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                                        Welcome, <?php echo $_SESSION['logged_in']['full_name']; ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="index.php">Home</a></li>
                                        <li><a class="dropdown-item" href="index.php#sec2">About</a></li>
                                        <li><a class="dropdown-item" style="cursor: pointer;" onclick="confirmLogout()">Logout</a></li>
                                    </ul>
                                </div>
                            <?php } elseif (isset($_SESSION['google_login'])) { ?> <!---------------------------------------- Using google oath  ------------------------------->
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                                        Welcome, <?php echo $_SESSION['google_login']['full_name']; ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="index.php">Home</a></li>

                                        <li><a class="dropdown-item" href="index.php#sec2">About</a></li>
                                        <li><a class="dropdown-item" style="cursor: pointer;" onclick="confirmLogout()">Logout</a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                            </a>
                        </div>
                        <!--------------------------------------------------------------- For SMALLER SCREENS end -------------------------------------------------->
                    </div>

                    <!----------------------------------------------------------- For larger screens    ----------------------------------------------------------->
                    <div class="d-none d-lg-flex ml-auto align-items-center">
                        <?php if (isset($_SESSION['logged_in'])) { ?>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                                    Welcome, <?php echo $_SESSION['logged_in']['full_name']; ?><!---------------------------------------- Using login form ------------------------------->
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="index.php#top">Home</a></li>
                                    <li><a class="dropdown-item" href="index.php#sec2">About</a></li>
                                    <li><a class="dropdown-item" style="cursor: pointer;" onclick="confirmLogout()">Logout</a></li>
                                </ul>
                            </div>
                        <?php } elseif (isset($_SESSION['google_login'])) { ?><!---------------------------------------- Using google oath  ------------------------------->
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton">
                                    Welcome, <?php echo $_SESSION['google_login']['full_name']; ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="index.php#top">Home</a></li>
                                    <li><a class="dropdown-item" href="index.php#sec2">About</a></li>
                                    <li><a class="dropdown-item" style="cursor: pointer;" onclick="confirmLogout()">Logout</a></li>
                                </ul>
                            </div>
                        <?php } else {  ?>

                            <div class="dropdown">
                                <a href="login.php">
                                    <button class="btn dropdown-toggle" id="dropdownMenuButton">
                                        Please Login
                                    </button>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <!------------------------------------------------------------- For larger screens end  ------------------------------------------------------------->
                </nav>
            </div>
        </div>
    </div>
</body>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Do you really wish to log out?',
            text: "This will sign you out and needs you to login again.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            confirmButtonColor: '#0096FF',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "logout.php"
            }
        });
    }
</script>

</html>