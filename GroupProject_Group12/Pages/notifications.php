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
    ?>
    
    <!-- 🔔 Notifications page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> Notifications </h2>
        </div>
        
        <div class="row gx-1">
            <?php
                // 🗃️ Database utilities
                require_once('../Database_Php_Interactions/Database_Utilities.php');

                // 🔗 Connect to the database
                $conn = Open_Database();
                
                // 🗑️ Delete notification
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
                    $notificationId = $_POST['NotifID'];
                    
                    // 🗑️ Delete notification from database
                    $deleteStmt = $conn->prepare("DELETE FROM Notifications WHERE NotifID = :NotifID");
                    $deleteStmt->bindValue(':NotifID', $notificationId, SQLITE3_INTEGER);
                    $deleteStmt->execute();
                    
                    // ↪️ Redirect to the notifications page after deletion
                    header("Location: notifications.php");
                    exit();
                }
                
                // 📨 Fetch notifications
                $notifStmt = $conn->prepare("SELECT NotifID, Body, Date FROM Notifications");
                $notifResult = $notifStmt->execute();
                
                // ⏱️ Notifcation age calculator
                function timeAgo($datetime) {
                    $now = new DateTime();
                    $past = new DateTime($datetime);
                    $diff = $now->diff($past);
                    
                    if ($diff->y > 0) return $diff->y . " year" . ($diff->y > 1 ? "s" : "") . " ago";
                    if ($diff->m > 0) return $diff->m . " month" . ($diff->m > 1 ? "s" : "") . " ago";
                    if ($diff->d > 6) return floor($diff->d / 7) . " week" . (floor($diff->d / 7) > 1 ? "s" : "") . " ago";
                    if ($diff->d > 0) return $diff->d . " day" . ($diff->d > 1 ? "s" : "") . " ago";
                    if ($diff->h > 0) return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago";
                    if ($diff->i > 0) return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago";
                    return "Just now";
                }
                
                // 🔄 Loop through the notifications and display them
                while ($notification = $notifResult->fetchArray(SQLITE3_ASSOC)) {
                    $notifBody = htmlspecialchars($notification['Body'] ?? '');
                    $notifID = htmlspecialchars($notification['NotifID'] ?? '');
                    $notifDate = $notification['Date'] ?? null;
                    $ageLabel = $notifDate ? timeAgo($notifDate) : '';
                    
                    echo '
                        <div class="card mb-3 d-flex">
                            <form method="POST" action="" style="display:inline;">
                                <div class="card-header">
                                    Notification
                                    <span style="font-size: 0.9em; margin-right: 2rem; float: right; opacity: 0.9;">' . htmlspecialchars($ageLabel) . '</span>
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
</html>