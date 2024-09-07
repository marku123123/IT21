<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link rel="Icon" href="image/halasan-logo.jpg" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/schedule_appointment.css">
</head>

<body class="register-body">

    <div class="register-container">

        <?php
        session_start();
        ?>

        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card rounded-3 text-black custom-card-width" style="min-width: 500px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.2);">
                    <div class="row g-0">

                        <div class="card-body p-md-5 mx-md-4">

                            <div class="text-center">
                                <img src="image/halasan-logo.jpg" style="width: 50px; display: inline-block; vertical-align: middle;" alt="logo">
                                <p class="nav" style="display: inline-block; margin: 0; vertical-align: middle; font-size:28px;">Schedule an Appointment</p>
                            </div>

                        
                            <?php 
                            /*
                            if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) : 
                            ?>
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
                            <?php endif;   */
                          ?>
                          

                            <form action="schedule_appointment_submit.php" method="post" class="registration-form">
                                <?php
                                if (isset($_SESSION['google_login'])) {
                                    $userID = $_SESSION['google_login']['userID'];
                                } elseif (isset($_SESSION['logged_in'])) {
                                    $userID = $_SESSION['logged_in']['userID'];
                                } else {
                                    echo "User ID not found.";
                                }
                                ?>
                                <!------------------------------------------ HIDE userID -------------------------------------------->
                                <?php if (isset($_SESSION['google_login'])) {
                                } ?>
                                <input type="hidden" id="userID" name="userID" value="<?php echo $userID; ?>" readonly>

                                <div class="outer_input">
                                    <input type="text" id="patient_name" title="Enter patient name" class="form-control" name="patient_name" placeholder="Patient name" autocomplete="off" required />
                                </div>

                                <div class="outer_input">
                                    <div class="select-wrapper">
                                        <select id="dental_service" name="dental_service" class="form-control" required>

                                            <option value="" selected disabled>Select dental service</option>
                                            <option value="General Dentistry">General Dentistry</option>
                                            <option value="Aesthetic Dentistry">Aesthetic Dentistry</option>
                                            <option value="Oral Hygiene">Oral Hygiene</option>
                                            <option value="Crowns">Crowns</option>
                                            <option value="Composite Resin Fillings">Composite Resin Fillings</option>
                                            <option value="Oral Surgery">Oral Surgery</option>
                                            <option value="Veneers">Veneers</option>
                                            <option value="Prosthodontic Dentistry / Dentures">Prosthodontic Dentistry / Dentures</option>
                                            <option value="Endodontic Dentistry/ Root Canal Treatment">Endodontic Dentistry/ Root Canal Treatment</option>
                                            <option value="Dental Implant">Dental Implant</option>
                                        </select>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>

                                <div class="outer-input">
                                    <!-- TIME SELECTION -->
                                    <div class="select-wrapper">
                                        <select id="time_in" name="time_in" class="form-control" required>
                                            <option value="" selected disabled> Select time</option>
                                            <option value="08:00">8:00 - 9:00 AM</option>
                                            <option value="09:00">9:00 - 10:00 AM</option>
                                            <option value="10:00">10:00 - 11:00 AM</option>
                                            <option value="" disabled class="separator">- - - - - - - - - - - - - A F T E R N O O N - - - - - - - - - - - - -</option>
                                            <option value="13:00">1:00 - 2:00 PM</option>
                                            <option value="14:00">2:00 - 3:00 PM</option>
                                            <option value="15:00">3:00 - 4:00 PM</option>
                                            <option value="16:00">4:00 - 5:00 PM</option>
                                            <option value="17:00">5:00 - 6:00 PM</option>
                                            <option value="18:00">6:00 - 7:00 PM</option>
                                            <option value="19:00">7:00 - 8:00 PM</option>
                                        </select>
                                        <i class="fas fa-chevron-down select-icon"></i>
                                    </div>
                                </div>


                                <div class="outer_input"> <!---------------------------------------- DATE -------------------------------------------------->
                                    <?php
                                    //SET TIMEZONE
                                    date_default_timezone_set('Asia/Manila');
                                    ?>
                                    <input type="date" id="appointment_date" class="form-control" name="appointment_date" placeholder="Date" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="outer_input">
                                    <input type="tel" id="phone_number" class="form-control" name="phone_number" inputmode="numeric" pattern="09[0-9]{9}" maxlength="11" placeholder="Contact Number (Ex. 09123456789)" title="Enter your 11-digit mobile number starting with 09" autocomplete="off" required onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 13" />
                                </div>

                                <!---------------------------------------- STATUS -------------------------------------------------->
                                <input type="hidden" id="status" name="status" value="Pending">

                                <br>
                                <div class="text-center pt-1 pb-1">
                                    <button class="submit-btn" id="submit" type="submit">Set Appointment</button>
                                </div>
                                <div class="text-center pt-1 mb-2 pb-1">
                                    <a href="index.php" class="Back-btn" id="Back-btn" type="submit">Go Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include("footer.php");
    ?>
</body>

</html>