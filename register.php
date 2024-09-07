<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATION PAGE</title>
    <link rel="Icon" href="image/halasan-logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/register.css">
</head>

<body class="register-body">

    <div class="register-container">

        <?php
        session_start();
        if (!isset($_SESSION['logged_in'])) { ?>


            <div class="row justify-content-center">

                <div class="col-md-6">
                    <div class="card rounded-3 text-black custom-card-width" style="min-width: 500px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <div class="row g-0">

                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                    <img src="image/halasan-logo.jpg" style="width: 50px; display: inline-block; vertical-align: middle;" alt="logo">
                                    <p class="nav" style="display: inline-block; margin: 0; vertical-align: middle; font-size:28px;">REGISTER ACCOUNT</p>
                                </div>

                                <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) : ?>
                                    <div class="errors">
                                        <ul>
                                            <?php foreach ($_SESSION['errors'] as $error) : ?>
                                                <li><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>

                                            <?php
                                            // Clear any previous error messages
                                            if (isset($_SESSION['errors'])) {
                                                unset($_SESSION['errors']);
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <form action="register_submit.php" method="post" class="registration-form">

                                    <div class="outer_input">
                                        <input type="text" id="username" title="Enter username" class="form-control" name="username" placeholder="Username" required />
                                    </div>

                                    <div class="outer_input">
                                        <input type="text" id="full_name" title="Enter full name" class="form-control" name="full_name" placeholder="Full Name" required />
                                    </div>

                                    <div class="outer_input">
                                        <input type="text" id="address" title="Enter permanent address" class=" form-control" name="address" placeholder="Your Permanent Address" required />
                                    </div>

                                    <div class="outer_input">
                                        <input type="password" id="password" title="Enter password" name="password" placeholder="Password" class="form-control" autocomplete="off" required />
                                    </div>

                                    <div class="outer_input">
                                        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" class="form-control" autocomplete="off" required />
                                    </div>

                                    <script>
                                        const passwordInputs = document.querySelectorAll('input[type="password"]');

                                        passwordInputs.forEach((input) => {
                                            const togglePassword = createToggleEyeIcon();
                                            input.parentNode.appendChild(togglePassword);

                                            togglePassword.addEventListener('click', function() {
                                                togglePasswordInputType(input, togglePassword);
                                            });
                                        });

                                        function createToggleEyeIcon() {
                                            const togglePassword = document.createElement('span');
                                            togglePassword.className = 'eye-icon';

                                            const eyeIcon = document.createElement('i');
                                            eyeIcon.className = 'fa-solid fa-eye';

                                            const eyeSlashIcon = document.createElement('i');
                                            eyeSlashIcon.className = 'fa-solid fa-eye-slash';
                                            eyeSlashIcon.style.display = 'none';

                                            togglePassword.appendChild(eyeIcon);
                                            togglePassword.appendChild(eyeSlashIcon);

                                            return togglePassword;
                                        }

                                        function togglePasswordInputType(input, togglePassword) {
                                            const eyeIcon = togglePassword.querySelector('.fa-eye');
                                            const eyeSlashIcon = togglePassword.querySelector('.fa-eye-slash');

                                            if (input.type === 'password') {
                                                input.type = 'text';
                                                eyeIcon.style.display = 'none';
                                                eyeSlashIcon.style.display = 'block';
                                            } else {
                                                input.type = 'password';
                                                eyeIcon.style.display = 'block';
                                                eyeSlashIcon.style.display = 'none';
                                            }
                                        }
                                    </script>



                                    <div class="text-center pt-3 pb-1"> <!-- padding top, padding bottom -->
                                        <button class="submit-btn" id="submit" type="submit">Sign Up</button>
                                    </div>
                                    <div class="text-center pt-1 mb-2 pb-1">
                                        <a href="login.php" class="Back-btn" id="Back-btn" type="submit">Go Back</a>
                                    </div>
                                </form>

                                <script>

                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php
    include("footer.php");

    ?>

</body>

</html>