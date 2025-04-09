<?php
session_start(); 
require('Database_Utilities.php');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Login_Email'], $_POST['Login_Password'])) {
    // 📨 Retrieve and trim user inputs
    $Email = trim($_POST['Login_Email']);
    $Password = trim($_POST['Login_Password']);
    
    // 🗃️ Open database connection
    $db = Open_Database();
    
    // 🗂️ Query data
    $query = "SELECT LoginID, Email, Password
              FROM LoginDetails
              WHERE Email = '" . $Email . "'";
    
    $stmt = $db->prepare($query);
    $result = $stmt->execute();
    
    // 🔎 Check if the user exists
    
    while ($Row = $result->fetchArray(SQLITE3_ASSOC)) {
        // ✅ Check password
        debug_to_console($Password);   
         
        if ($Password === $Row['Password']) {
            $_SESSION['Email'] = $Row['Email'];
            $LoginID = $Row['LoginID'];
 
            $UserDetailQuery = $db->prepare('SELECT User_ID, RoleID, FName, SName, PhoneNo, StreetName, HouseNo FROM User_Details WHERE LoginID = ' . $LoginID);
            $UserRes = $UserDetailQuery -> execute();
            if ($row = $UserRes -> fetchArray(SQLITE3_ASSOC)) {
                // 💾 Store user details in session
                $_SESSION['UserID'] = $row['User_ID'];                
                $_SESSION['RoleID'] = $row['RoleID'];
                $_SESSION['FName'] = $row['FName'];
                $_SESSION['SName'] = $row['SName'];
                $_SESSION['PhoneNo'] = $row['PhoneNo'];
                $_SESSION['StreetName'] = $row['StreetName'];
                $_SESSION['HouseNo'] = $row['HouseNo'];
                
                // 🎭 Determine role details (based on assignment of network or city)
                $RoleQuery = $db->prepare('SELECT CityID, NetworkID FROM Assignations WHERE UserID = ?');
                $RoleQuery->bindParam(1, $row['User_ID'], SQLITE3_INTEGER);
                $RoleQueryRes = $RoleQuery->execute();
                
                $roleDetails = $RoleQueryRes->fetchArray(SQLITE3_ASSOC);
                if ($roleDetails) {
                    if ($_SESSION['RoleID'] == '2') {
                        $RoleNameQuery = $db->prepare('SELECT NetworkName FROM Network WHERE NetworkID = ' . $roleDetails['NetworkID']);
                        $RoleNameQueryres = $RoleNameQuery->execute();
                        
                        $_SESSION['Network_Name'] = $RoleNameQueryres->fetchArray(SQLITE3_ASSOC)['NetworkName'];    
                    } elseif ($_SESSION['RoleID'] == '3') {
                        $RoleNameQuery = $db->prepare('SELECT City_Name FROM City WHERE CityID = ' . $roleDetails['CityID']);
                        $RoleNameQueryres = $RoleNameQuery->execute();
                        $_SESSION['City_Name'] = $RoleNameQueryres->fetchArray(SQLITE3_ASSOC)['City_Name'];
                    }
                }

                // 🎉 Redirect to home page
                $db->close();
                header("Location: /Group_Project/GroupProject_Group12/pages/home.php");
                exit();
            }
        }
        
    }
    
    // ⚠️ Give error if authentication fails
    $db->close();
    $message = urlencode("Invalid email or password.");
    header("Location: /Group_Project/GroupProject_Group12/pages/home.php?error=" . $message);
    exit();
}
?>