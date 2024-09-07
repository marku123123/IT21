<?php
session_start(); // Ensure session is started

require_once('../database/dbconn.php');
require_once('log_audit.php'); // Correct path to log_audit.php

if (isset($_GET['bookingID'])) {
    $bookingID = $_GET['bookingID'];
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    try {
        $conn->beginTransaction();

        if ($action == 'Approved') {
            // Update the selected booking to 'Approved'
            $sql = "UPDATE appointments SET status = 'Approved' WHERE bookingID = :bookingID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
            $stmt->execute();

            // Get details of the approved booking
            $sql = "SELECT * FROM appointments WHERE bookingID = :bookingID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
            $stmt->execute();
            $appointment_details = $stmt->fetch(PDO::FETCH_ASSOC);

            $appointment_date = $appointment_details['appointment_date'];
            $timeIn = $appointment_details['time_in'];
            $timeOut = $appointment_details['time_out'];
            $userID = $appointment_details['userID'];        // -------------------------- PARA MAKUHA ANG USERID UG NAME -------------------------- 

            // Update other pending bookings for the same room, date, and time to 'Denied'
            $sql = "UPDATE appointments SET status = 'Denied' WHERE appointment_date = :appointment_date AND time_in = :time_in AND status = 'Pending'";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':appointment_date', $appointment_date, PDO::PARAM_STR);
            $stmt->bindParam(':time_in', $timeIn, PDO::PARAM_STR);
            $stmt->execute();

            // ------------------------------------------------------------ FOR AUDIT LOGS ------------------------------------------------------------
            $sql = "SELECT * FROM users WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $full_name = $row['full_name'];

            // SET TIME TO 12-HR CLOCK FORMAT
            $timeIn = date('g:i A', strtotime($timeIn)); 
            $timeOut = date('g:i A', strtotime($timeOut));

            // Log the appointment approval
            log_audit(
                $_SESSION['logged_in']['userID'],
                'Appointment Approved',
                'Reserved by: ' . $full_name . ', ' . 'Patient: ' . htmlspecialchars($appointment_details['patient_name']) . ', Service: ' . htmlspecialchars($appointment_details['dental_service']) . 
                ', Date: ' . htmlspecialchars($appointment_date) . 
                ', Time: '.htmlspecialchars($timeIn).'-'.htmlspecialchars( $timeOut).'.'
            );
        } elseif ($action == 'Denied') {
            // Update the selected booking to 'Denied'

            $sql = "UPDATE appointments SET status = 'Denied' WHERE bookingID = :bookingID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
            $stmt->execute();

            // Get details of the denied booking
            $sql = "SELECT * FROM appointments WHERE bookingID = :bookingID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
            $stmt->execute();
            $appointment_details = $stmt->fetch(PDO::FETCH_ASSOC);

            $appointment_date = $appointment_details['appointment_date'];
            $timeIn = $appointment_details['time_in'];
            $timeOut = $appointment_details['time_out'];
            $userID = $appointment_details['userID'];        // -------------------------- PARA MAKUHA ANG USERID UG NAME -------------------------- 

            // ------------------------------------------------------------ FOR AUDIT LOGS ------------------------------------------------------------
            //QUERY FOR GETTING USER DATA
            $sql = "SELECT * FROM users WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $full_name = $row['full_name'];

            // SET TIME TO 12-HR CLOCK FORMAT
            $timeIn = date('g:i A', strtotime($timeIn)); 
            $timeOut = date('g:i A', strtotime($timeOut));

            log_audit(
                $_SESSION['logged_in']['userID'],
                'Appointment Denied',
                'Reserved by: ' . $full_name . ', ' . 'Patient: ' . htmlspecialchars($appointment_details['patient_name']) . ', Service: ' . htmlspecialchars($appointment_details['dental_service']) . 
                ', Date: ' . htmlspecialchars($appointment_date) . 
                ', Time: '.htmlspecialchars($timeIn).'-'.htmlspecialchars( $timeOut).'.'
            );
        }

        $conn->commit();
        header('Location: admin_manage_appointments.php');
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "ERROR: " . $e->getMessage();
    }
}

$conn = null;
