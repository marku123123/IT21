<?php
require_once('database/dbconn.php');

try {
    $sql = "UPDATE user SET name = :newname, username = :newusername, address = :newaddress, role = :newrole, phonenumber = :newphonenumber WHERE userID = :userID";
    $stmt = $conn->prepare($sql);

    // Bind the parameters correctly
    $stmt->bindParam(':userID', $_GET['userID'], PDO::PARAM_STR);
    $stmt->bindParam(':newname', $_GET['newname'], PDO::PARAM_STR);
    $stmt->bindParam(':newusername', $_GET['newusername'], PDO::PARAM_STR);
    $stmt->bindParam(':newaddress', $_GET['newaddress'], PDO::PARAM_STR);
    $stmt->bindParam(':newrole', $_GET['newrole'], PDO::PARAM_STR);
    $stmt->bindParam(':newphonenumber', $_GET['newphonenumber'], PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Redirect to the managecustomer.php page after the update
    header('Location: managecustomer.php');
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

$conn = null;
