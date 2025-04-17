<?php
    
    // 🗃️ Database utilities
    require_once('../Database_Php_Interactions/Database_Utilities.php');
    
    // 🔗 Connect to database
    $db = Open_Database();
    
    // 👤 Get current user ID
    $userID = $_SESSION['UserID'] ?? null; // Get current user ID, if logged in
    echo '<script>console.log("UserID: ' . $userID . '");</script>';
    
    // 📖 Update read status (AJAX)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['markAsRead'])) {
        $notifID = $_POST['NotifID'];
        $isRead = $_POST['isRead'] == '1' ? 1 : 0;
        
        $updateStmt = $db->prepare("UPDATE Notifications SET Read = :isRead WHERE NotifID = :notifID");
        $updateStmt->bindValue(':isRead', $isRead, SQLITE3_INTEGER);
        $updateStmt->bindValue(':notifID', $notifID, SQLITE3_INTEGER);
        $updateStmt->execute();
        
        exit(); // 🛑 Exit before any echo
    }
    
    // 🗑️ Delete notification
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteNotification'])) {
        $notifID = $_POST['NotifID'];
        
        // 🗑️ Delete notification from database
        $deleteStmt = $db->prepare("DELETE FROM Notifications WHERE NotifID = :NotifID");
        $deleteStmt->bindValue(':NotifID', $notifID, SQLITE3_INTEGER);
        $deleteStmt->execute();
        
        // ↪️ Redirect to notifications page after deletion
        header("Location: notifications.php");
        exit();
    }
    
?>