<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Notifications - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar and login -->
    <?php 
        include("../modules/notification-functions.php");
        include("../modules/navbar.php");
        include("../modules/login.php");
    ?>
    
    <!-- 🔔 Notifications page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> Notifications </h2>
        </div>
        
        <div class="row gx-1">
            <?php
                // 📨 Fetch notifications
                $notifStmt = $db->prepare("SELECT NotifID, UserID, Header, Body, Date, Read
                                           FROM Notifications
                                           WHERE UserID = :userId OR UserID = 0
                                           ORDER BY Date DESC");
                $notifStmt->bindValue(':userId', $userId, SQLITE3_TEXT);
                $notifResult = $notifStmt->execute();
                
                // 🔄 Loop through notifications and display
                while ($notif = $notifResult->fetchArray(SQLITE3_ASSOC)) {
                    $notifBody = htmlspecialchars($notif['Body'] ?? '');
                    $notifID = htmlspecialchars($notif['NotifID'] ?? '');
                    $notifDate = $notif['Date'] ?? null;
                    $ageLabel = $notifDate ? timeAgo($notifDate) : '';
                    $notifFullDate = $notifDate ? (new DateTime($notifDate))->format('j M Y H:i:s') : ''; // 📅 Full timestamp
                    
                    // ⭐ Star if notification is targeted to current user
                    $starClass = ($notif['UserID'] == $userId) ? 'filled-star' : '';
                    
                    // 📖 Mark as read toggle (dot to hollow circle effect)
                    $markAsReadClass = ($notif['Read'] == 0) ? 'unread-dot' : 'read-dot';
                    
                    echo '
                        <div class="card mb-3 d-flex">
                            <form method="POST" action="">
                                <div class="card-header">
                                    <!-- ⭐ Star for targeted notification -->
                                    ' . ($notif['UserID'] == $userId ? '<span class="filled-star" style="cursor: pointer;" data-tooltip="This notification is targeted at you">&#9733;</span>' : '') . '
                                    ' . htmlspecialchars($notif['Header'] ?? '') . '
                                    <span 
                                        style="font-size: 0.9em; margin-right: 2rem; float: right; opacity: 0.9;"
                                        data-tooltip="' . htmlspecialchars($notifFullDate) . '"
                                    >' . htmlspecialchars($ageLabel) . '</span>
                                    <!-- 🗑️ Delete button -->
                                    <span data-tooltip="Delete notification" style="position: absolute; right: 12px">
                                        <button type="submit" name="deleteNotification" class="btn-close" aria-label="Delete notification"></button>
                                    </span>
                                    <!-- 📖 Mark as read dot -->
                                    <span class="' . $markAsReadClass . '" data-tooltip="Toggle read status" style="cursor: pointer; margin-right: 1rem; float: right;" onclick="toggleReadStatus(' . $notif['NotifID'] . ', this)"></span>
                                </div>
                                <div class="card-body">
                                    <p>
                                        ' . htmlspecialchars($notif['Body'] ?? '') . '
                                    </p>
                                    <input type="hidden" name="NotifID" value="' . htmlspecialchars($notif['NotifID'] ?? '') . '"/>
                                </div>
                            </form>
                        </div>
                        <script>console.log("Loaded body notif:", ' . json_encode($notif['NotifID']) . ');</script>
                    ';
                }
            ?>
            
            <div class="card mb-3 d-flex">
                <div class="card-header">
                    <h2> Create Notification </h2>
                </div>
                
                <div class="card-body">
                    <form action="../Database_Php_Interactions/create_notification.php" method="POST">
                        <label for="user_id"> User ID (leave blank for all users): </label>
                        <input type="number" name="user_id" id="user_id"><br><br>
                        
                        <label for="header"> Header: </label>
                        <input type="text" name="header" id="header" required><br><br>
                        
                        <label for="body"> Body (optional): </label>
                        <textarea name="body" id="body" rows="4"></textarea><br><br>
                        
                        <label for="date"> Date and time: </label>
                        <input type="datetime-local" name="date" id="date" required><br><br>
                        
                        <label for="read"> Read: </label>
                        <input type="checkbox" name="read" id="read"><br><br>
                        
                        <button type="submit" class="fancy-button"> Send Notification </button>
                    </form>
                </div>
            </div>
            
            <script>
                // Auto-fill date and time input field with current date and time
                document.addEventListener("DOMContentLoaded", function() {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0'); // 🙄 Month is 0-based apparently
                    const day = String(now.getDate()).padStart(2, '0');
                    const hour = String(now.getHours()).padStart(2, '0'); // Maybe should have -1?? - probably not though
                    const minute = String(now.getMinutes()).padStart(2, '0');
                    const second = String(now.getSeconds()).padStart(2, '0'); // Have to set the seconds as 0 since apparently chrome won't accept other values??? 🙄🙄🙄
                    
                    // 📅 Format date and time string as "YYYY-MM-DDTHH:MM:SS" so as to match input format
                    const dateTime = year + '-' + month + '-' + day + 'T' + hour + ':' + minute + ':' + second;
                    
                    // ⏰ Set input field placeholder value to current date and time
                    document.getElementById('date').value = dateTime;
                });
            </script>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>