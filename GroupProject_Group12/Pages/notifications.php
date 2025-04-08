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
            <h2> Notifications </h2>
        </div>
        
        <div class="row gx-1">
            <?php
                // 🔗 Connect to the database
                $conn = Open_Database();
                
                // 📨 Fetch notifications
                $notifStmt = $conn->prepare("SELECT NotifID, Body FROM Notifications");
                $notifResult = $notifStmt->execute();
                
                // 🔄 Loop through the notifications and display them
                while ($notification = $notifResult->fetchArray(SQLITE3_ASSOC)) {
                    echo '
                        <div class="card mb-3 d-flex">
                            <form method="POST" action="" style="display:inline;">
                                <div class="card-header">
                                    Notification
                                    <button type="submit" name="deleteNotification" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 12px"></button>
                                </div>
                                <div class="card-body">
                                    <p class="notification-text">' . htmlspecialchars($notification['Body'] ?? '') . '</p>
                                    <input type="hidden" name="NotifID" value="' . htmlspecialchars($notification['NotifID'] ?? '') . '"/>
                                </div>
                            </form>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>

<?php
    // 🗑️ Delete notification
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
        $notificationId = $_POST['NotifID'];
        
        // 🗑️ Delete notification from database
        $deleteStmt = $conn->prepare("DELETE FROM Notifications WHERE NotifID = :NotifID");
        $deleteStmt->bindValue(':NotifID', $notificationId, SQLITE3_INTEGER);
        $deleteStmt->execute();
        
        // Redirect to the notifications page after deletion
        header("Location: notifications.php");
        exit();
    }
?>

</html>