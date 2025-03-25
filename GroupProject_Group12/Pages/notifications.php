<!DOCTYPE html>
<html lang="en-gb">

<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Notifications - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>

    <!-- 🔔 Notifications Page Content -->
    <div class="container mt-4">
        <h2>Notifications</h2>
        <div class="notification-list">
            <!-- 🔄 Loop through notifications and display them -->
            <div class="notification">🔔 This is a notification</div>
            <div class="notification">🔔 This is another notification.</div>
        </div>
    </div>

</body>


<?php
// Fetch notifications for the employee
$notifStmt = $conn->prepare("SELECT NotifID, User_ID, Notifications
                             FROM Notifications;
$notifResult = $notifStmt->execute();

$notifications = [];
while ($notif = $notifResult->fetchArray(SQLITE3_ASSOC)) {
    $notifications[] = $notif;
}
// Handle the deletion of a notification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
    $notificationId = $_POST['NotifID'];

    // Delete the notification from the database
    $deleteStmt = $conn->prepare("DELETE FROM Notifications WHERE NotificationID = :notificationId");
    $deleteStmt->bindValue(':NotifID', $notificationId, SQLITE3_INTEGER);
    $deleteStmt->execute();

    // Redirect to home page to refresh the notifications
    header("Location: notifications.php");
    exit();
}

?>
</html>