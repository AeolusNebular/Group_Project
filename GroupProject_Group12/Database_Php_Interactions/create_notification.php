<?php
    // 🗃️ Database utilities
    require_once('../Database_Php_Interactions/Database_Utilities.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $user_id = $_POST['user_id'];
        $header = $_POST['header'];
        $body = isset($_POST['body']) ? $_POST['body'] : NULL;
        $date = $_POST['date'] ? $_POST['date'] : date('Y-m-d H:i:s'); // Use current datetime by default
        $read = isset($_POST['read']) ? 1 : 0; // Convert checkbox to binary
        
        // Validate input data
        if (empty($header) || empty($date)) {
            echo "Error: Please fill in all required fields!";
            exit;
        }
        
        // 🕒 Process and format datetime
        $formattedDate = $date;
        if (strpos($formattedDate, 'T') !== false) {
            $formattedDate = str_replace('T', ' ', $formattedDate);  // Change 'T' to a space
        }
        
        // 🔗 Connect to database
        $db = Open_Database();
        
        // Insert into database
        $stmt = $db->prepare("INSERT INTO Notifications (UserID, Header, Body, Date, Read)
                                VALUES (:user_id, :header, :body, :date, :read)");
        
        // Bind parameters
        $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
        $stmt->bindValue(':header', $header, SQLITE3_TEXT);
        $stmt->bindValue(':body', $body, SQLITE3_TEXT);
        $stmt->bindValue(':date', $formattedDate, SQLITE3_TEXT); // Use formatted date
        $stmt->bindValue(':read', $read, SQLITE3_INTEGER);
        
        // Execute query
        if ($stmt->execute()) {
            echo "Notification created successfully!";
            
            // ↪️ Redirect to notifications page after creation
            header("Location: ../pages/notifications.php");
        } else {
            echo "Error: Could not create notification.";
        }
    } else {
        echo "Invalid request.";
    }
?>