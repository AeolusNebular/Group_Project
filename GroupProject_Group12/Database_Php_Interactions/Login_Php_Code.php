<?php
    session_start();
    require('Database_Utilities.php');
    
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Login_Email']) && isset($_POST['Login_Password'])) {
        // 📨 Retrieve and trim user inputs
        $Email = trim($_POST['Login_Email']);
        $Password = trim($_POST['Login_Password']);

        $query = "select User_ID, FName, PhoneNo, SName, HouseNo, StreetName, Email, Password, RoleID FROM User_Details, LoginDetails WHERE Email = '".$Email."'";
        
        // 🛢️ Open database connection
        $db = Open_Database();
        $stmt = $db->prepare($query);
        $result = $stmt->execute();

        // 🔎 Check if the user exists and password matches
        $userFound = false;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $storedPassword = $row['Password'];
            if ($Password === $storedPassword) {
                
                // ✅ Successful login, store details in session
                $_SESSION['UserID'] = $row['User_ID'];
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['RoleID'] = $row['RoleID'];            
                $_SESSION['FName'] = $row['FName'];         
                $_SESSION['SName'] = $row['SName'];               
                $_SESSION['PhoneNo'] = $row['PhoneNo'];
                $_SESSION['StreetName'] = $row['StreetName'];
                $_SESSION['HouseNo'] = $row['HouseNo'];
                
                // 🎭 Fetch role details (network or city name)
                $RoleQuery = $db -> prepare('SELECT City_Name, NetworkName FROM Assignations WHERE UserID =' . $row['User_ID']);
                $RoleQueryRes = $RoleQuery ->execute();

                if ($RoleQueryRes) {
                    if ($_SESSION['RoleID'] == '2') {
                        $_SESSION['Network_Name'] = $RoleQueryRes->fetchArray(SQLITE3_ASSOC)['NetworkName']; 
                        debug_to_console($_SESSION['Network_Name']);    
                    } elseif ($row['RoleID'] == '3') {
                        $_SESSION['City_Name'] = $RoleQueryRes->fetchArray(SQLITE3_ASSOC)['City_Name'];
                        debug_to_console($_SESSION['City_Name']); 
                    } elseif ($row['RoleID'] == '1') {
                        
                    } else {
                        debug_to_console("Failed to select network or city " . $db -> lastErrorMsg());
                        $db->close();
                        exit;
                    }
                }
                
                // 🎉 Redirect to home page
                header("Location: /Group_Project/GroupProject_Group12/pages/home.php");
                exit();
            }
        }
        
        // ⚠️ Give error if authentication fails
        $message = urlencode("Invalid email or password.");
        header("Location: /Group_Project/GroupProject_Group12/Pages/home.php?error=" . $message);
        exit();
    }
?>