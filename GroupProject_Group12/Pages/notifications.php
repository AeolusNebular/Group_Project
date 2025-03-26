<!DOCTYPE html>
<html lang="en-gb">

<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Notifications - Smart Energy Dashboard</title>
</head>

    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); 
    require('../Database_Php_Interactions/Database_Utilities.php'); ?>

    <!-- 🔔 Notifications Page Content -->
    <div class="container mt-4">
        <h2>Notifications</h2>
        <div class="notification-list">
            
        <Echo "NotifStmt" />


        </div>
    </div>

</body>


<?php

$conn = Open_Database();
// Fetch notifications
$notifStmt = $conn->prepare("SELECT NotifID, User_ID, Notification FROM Notifications");
$notifResult = $notifStmt->execute();

$notifications = [];
while ($NotifID = $notifResult->fetchArray(SQLITE3_ASSOC)) {
    $notifications['NotifID'] = $NotifID;
};


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
    $notificationId = $_POST['NotifID'];



    $deleteStmt = $conn->prepare("DELETE FROM Notifications WHERE NotifID = :NotificationId");
    $deleteStmt->bindValue(':NotifID', $notificationId, SQLITE3_INTEGER);
    $deleteStmt->execute();

    header("Location: notifications.php");
    exit();
}



?>
</html>