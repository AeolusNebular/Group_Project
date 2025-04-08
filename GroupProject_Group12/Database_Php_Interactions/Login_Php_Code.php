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
    $query = "SELECT User_ID, UserID, FName, PhoneNo, SName, HouseNo, StreetName, Email, Password, RoleID
              FROM User_Details, LoginDetails
              WHERE Email = '".$Email."'";
    
    $stmt = $db->prepare($query);
    $result = $stmt->execute();
    
    // 🔎 Check if the user exists
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {

        // ✅ Check password
        if ($row['User_ID'] === $row['UserID']){
            if ($Password === $row['Password']) {
                
                // 💾 Store user details in session
                $_SESSION['UserID'] = $row['User_ID'];
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['RoleID'] = $row['RoleID'];
                $_SESSION['FName'] = $row['Fname'];
                $_SESSION['SName'] = $row['SName'];
                $_SESSION['PhoneNo'] = $row['PhoneNo'];
                $_SESSION['StreetName'] = $row['StreetName'];
                $_SESSION['HouseNo'] = $row['HouseNo'];
                
                // 🎭 Determine role details (based on assignment of network or city)
                $RoleQuery = $db->prepare('SELECT City_Name, NetworkName FROM Assignations WHERE UserID = ?');
                $RoleQuery->bindParam(1, $row['User_ID'], SQLITE3_INTEGER);
                $RoleQueryRes = $RoleQuery->execute();
                
                $roleDetails = $RoleQueryRes->fetchArray(SQLITE3_ASSOC);
                if ($roleDetails) {
                    if ($_SESSION['RoleID'] == '2') {
                        $_SESSION['Network_Name'] = $roleDetails['NetworkName'];    
                    } elseif ($_SESSION['RoleID'] == '3') {
                        $_SESSION['City_Name'] = $roleDetails['City_Name'];
                    }
                }

                // 🎉 Redirect to home page
                header("Location: /Group_Project/GroupProject_Group12/pages/home.php");
                exit();
            }
        }
    }
    
    // ⚠️ Give error if authentication fails
    $message = urlencode("Invalid email or password.");
    header("Location: /Group_Project/GroupProject_Group12/pages/home.php?error=" . $message);
    exit();
}
?>