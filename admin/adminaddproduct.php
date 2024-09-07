<?php
session_start();
require_once('dbconn.php');

try {
    $stmt = $conn->prepare("INSERT INTO fooditem (menuname, availability, menutype, menuprice, menuprofile) VALUES (:menuname, :availability, :menutype, :menuprice, :menuprofile)");
    $stmt->bindParam(':menuname', $_POST['newmenuname'], PDO::PARAM_STR);
    $stmt->bindParam(':availability', $_POST['newavailability'], PDO::PARAM_STR);
    $stmt->bindParam(':menutype', $_POST['newmenutype'], PDO::PARAM_STR);
    $stmt->bindParam(':menuprice', $_POST['newmenuprice'], PDO::PARAM_STR);
    $stmt->bindParam(':menuprofile', $_POST['newmenuprofile'], PDO::PARAM_STR);

    if (isset($_FILES['newmenuprofile']) && $_FILES['newmenuprofile']['error'] == 0) {
        $file_name = $_FILES['newmenuprofile']['name'];
        $file_size = $_FILES['newmenuprofile']['size'];
        $file_tmp = $_FILES['newmenuprofile']['tmp_name'];
        $file_type = $_FILES['newmenuprofile']['type'];

        $fp = fopen($file_tmp, 'r');
        $content = fread($fp, filesize($file_tmp));
        fclose($fp);

        $stmt->bindParam(':menuprofile', $content, PDO::PARAM_LOB);
    } else {
        $stmt->bindValue(':menuprofile', NULL, PDO::PARAM_NULL);
    }

    $stmt->execute();
    $_SESSION['itemInserted_Success'] = "Successfully_inserted";
    header('Location: manageproduct.php');
    exit(); // It's good practice to exit after a redirect
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

$conn = null;
