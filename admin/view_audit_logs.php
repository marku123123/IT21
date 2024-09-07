<?php
if (!isset($_SESSION)) {
    session_start();
}
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect to the login page
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN-VIEW-AUDIT-LOGS</title>
    <link rel="Icon" href="../image/halasan-logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/admin.css">
    <link rel="stylesheet" href="../style/loader.css">
</head>

<body>
    <?php
    include("../loader.php");
    require_once('../database/dbconn.php');
    include 'admin_navbar.php';

    try {
        $stmt = $conn->prepare("SELECT audit_log.*, users.full_name 
                                FROM audit_log 
                                JOIN users ON audit_log.user_id = users.userID 
                                ORDER BY audit_log.id DESC");
        $stmt->execute();
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div class='container mt-5 alert alert-danger'>ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
        $logs = []; // Set logs to an empty array in case of error
    }
    ?>
    <br>
    <div class="container mt-5">
        <h1 style="margin-top: 100px;">AUDIT LOGS</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User Full Name</th>
                    <th scope="col">Action</th>
                    <th scope="col">Details</th>
                    <th scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)) : ?>
                    <tr>
                        <td colspan="5" class="text-center">No logs found.</td>
                    </tr>
                <?php else : ?>
                    <?php
                    // Set the timezone to Asia/Manila
                    date_default_timezone_set("Asia/Manila");
                    ?>
                    <?php foreach ($logs as $log) : ?>
                        <tr>
                            <td><?= htmlspecialchars($log['id']); ?></td>
                            <td><?= htmlspecialchars($log['full_name']); ?></td>
                            <td><?= htmlspecialchars($log['action']); ?></td>
                            <td><?= htmlspecialchars($log['details']); ?></td>
                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($log['timestamp'])));?><br><?= htmlspecialchars(date('g:i:s A', strtotime($log['timestamp'])));?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>