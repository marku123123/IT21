<?php
session_start();
require_once('database/dbconn.php');

// Access the submitted values
$room_name = $_POST['room_name'];
$room_quantity = $_POST['room_quantity'];
$status = $_POST['status'];
$room_capacity = $_POST['room_capacity'];
$room_profile = $_FILES['room_profile'];


try {
    // Check if the room name already exists
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM rooms WHERE room_name = :room_name");
    $check_stmt->bindParam(':room_name', $room_name, PDO::PARAM_STR);
    $check_stmt->execute();
    $room_exists = $check_stmt->fetchColumn();

    if ($room_exists > 0) {
        // Room name already exists
        $_SESSION['itemInserted_Failure'] = "Room name already exists.";
        echo "<script>alert('Room name already exists. Please change the room name.');window.history.back();</script>";
        exit();
    }
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO rooms (room_name, room_quantity, status, room_capacity, room_profile) 
    VALUES (:room_name, :room_quantity, :status, :room_capacity, :room_profile)");
    $stmt->bindParam(':room_name', $room_name, PDO::PARAM_STR);
    $stmt->bindParam(':room_quantity', $room_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':room_capacity', $room_capacity, PDO::PARAM_INT);

    // Handle the uploaded file
    if (isset($_FILES['room_profile']) && $_FILES['room_profile']['error'] == 0) {
        $room_profile_tmp_name = $_FILES['room_profile']['tmp_name'];
        $fp = fopen(
            $room_profile_tmp_name,
            'rb'
        ); // Open the file in binary mode
        $content = fread($fp, filesize($room_profile_tmp_name)); // Read the file content
        fclose($fp); // Close the file
        $stmt->bindParam(
            ':room_profile',
            $content,
            PDO::PARAM_LOB
        ); // Bind the content as a BLOB
    } else {
        $stmt->bindValue(':room_profile', NULL, PDO::PARAM_NULL); // If no file is uploaded, bind NULL
    }

    // Execute the SQL statement
    $stmt->execute();
    $_SESSION['itemInserted_Success'] = "Room inserted successfully.";
    echo "<script>alert('Room inserted successfully.');window.location.href='admin_manage_rooms.php';</script>";
    // header('Location: admin_manage_rooms.php');
    exit();
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

$conn = null;
