<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Notifications - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); 
    require_once('../Database_Php_Interactions/Database_Utilities.php'); ?>
    
    <!-- 🔔 Notifications page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Notifications</h2>
        </div>
        
        <div class="notification-list">
            <?php
                // Connect to the database
                $conn = Open_Database();
                
                // Fetch notifications
                $notifStmt = $conn->prepare("SELECT NotifID, Notification FROM Notifications");
                $notifResult = $notifStmt->execute();

                // 🔄 Loop through the notifications and display them
                while ($notification = $notifResult->fetchArray(SQLITE3_ASSOC)) {
                    echo '<div class="notification-item">';
                    echo '<p class="notification-text">' . htmlspecialchars($notification['Notification']) . '</p>';
                    // delete
                    echo '<form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="NotifID" value="' . $notification['NotifID'] . '" />
                            <button type="submit" name="deleteNotification" class="btn btn-danger delete-button">Delete</button>
                          </form>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>

</body>

<?php
//  Delete notification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
    $notificationId = $_POST['NotifID'];
    
    // Delete notification from database
    $deleteStmt = $conn->prepare("DELETE FROM Notifications WHERE NotifID = :NotifID");
    $deleteStmt->bindValue(':NotifID', $notificationId, SQLITE3_INTEGER);
    $deleteStmt->execute();

    // Redirect to the notifications page after deletion
    header("Location: notifications.php");
    exit();
}
?>

</html>