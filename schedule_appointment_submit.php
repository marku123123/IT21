<?php
session_start();
require_once('database/dbconn.php');
require_once 'admin/log_audit.php'; // Include the audit logging function

// Start a transaction
$conn->beginTransaction();

// Get the values posted from the form
$userID = $_POST['userID'];
$patient_name = $_POST['patient_name'];
$dental_service = $_POST['dental_service'];
$time_in = $_POST['time_in'];
$appointment_date = $_POST['appointment_date'];
$phone_number = $_POST['phone_number'];
$status = $_POST['status'];

// Calculate the time out by adding 1 hour to the time in
$time_out = date('H:i', strtotime($time_in) + 3600);

// Validate the user ID
if (!isset($userID) || empty($userID) || !is_numeric($userID)) {
    echo "Invalid User ID";
    exit();
}

// Validate the user ID by querying the database
$stmt = $conn->prepare("SELECT * FROM users WHERE userID = :userID");
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Invalid User ID";
    exit();
}

// Sanitize input
$appointment_date = htmlspecialchars($appointment_date);
$timeIn = htmlspecialchars($time_in);
$timeOut = date('H:i', strtotime($timeIn) + 3600); // H:i (Hours and minutes)
$status = htmlspecialchars($status);

// Validate required fields
if (!empty($appointment_date) && !empty($time_in)) {
    // Check if the room is booked with 'Approved' status for the selected time
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE dental_service = :dental_service AND appointment_date = :appointment_date AND time_in = :time_in AND status = 'Approved'");
    $stmt->bindParam(':dental_service', $dental_service);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':time_in', $time_in);
    $stmt->execute();
    $approvedBookingExists = $stmt->fetchColumn();

    if ($approvedBookingExists > 0) {
        echo "<script>alert('This room is already booked at the selected time. Please choose another time or another room.'); window.history.back();</script>";
        exit();
    }

    // Check if the current user's booking is denied at the selected time
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = :appointment_date AND time_in = :time_in AND userID = :userID AND status = 'Denied'");
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':time_in', $timeIn);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $deniedExists = $stmt->fetchColumn();

    if ($deniedExists > 0) {
        echo "<script>alert('Request denied. Please select another time or date.'); window.history.back();</script>";
        exit();
    }

    // Check if the current user already has a pending appointment at the selected time
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = :appointment_date AND time_in = :time_in AND userID = :userID AND status = 'Pending'");
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':time_in', $timeIn);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $reservationExists = $stmt->fetchColumn();

    if ($reservationExists > 0) {
        echo "<script>alert('You have already set an appointment for this time. Kindly wait for the response.'); window.history.back();</script>";
        exit();
    }

    try {
        // Prepare and bind the SQL statement for booking
        $stmt = $conn->prepare("INSERT INTO appointments (userID, patient_name, dental_service, appointment_date, phone_number, time_in, time_out, status) VALUES (:userID, :patient_name, :dental_service, :appointment_date, :phone_number, :time_in, :time_out, :status)");
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':patient_name', $patient_name);
        $stmt->bindParam(':dental_service', $dental_service);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':time_in', $time_in);
        $stmt->bindParam(':time_out', $time_out);
        $stmt->bindParam(':status', $status);

        // Execute the statement
        if ($stmt->execute()) {
            $conn->commit();

            // Log the appointment scheduling
            log_audit($userID, 'Schedule Appointment', 'Appointment scheduled with details: Patient: ' . $patient_name . ', Service: ' . $dental_service);

            echo "<script>alert('Appointment submitted successfully!'); window.location.href='index.php#sec3';</script>";
        } else {
            throw new Exception("Failed to insert appointment.");
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

    // Close the statement
    $stmt = null;
} else {
    echo "Please fill in all required fields.";
}

// Close the connection
$conn = null;
