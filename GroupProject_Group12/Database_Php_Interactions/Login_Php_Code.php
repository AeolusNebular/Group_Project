<?php
    session_start();
    require('Database_Utilities.php');



    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Login_Email']) && isset($_POST['Login_Password'])) {
        // Get user details using email from User_Details and link with LoginDetails
        $Email = trim($_POST['Login_Email']);
        $Password = trim($_POST['Login_Password']);

        $query = "select User_ID, FName, PhoneNo, SName, HouseNo, StreetName, Email, Password, RoleID FROM User_Details, LoginDetails WHERE Email = '".$Email."'";

       
        $db = Open_Database();
        $stmt = $db->prepare($query);
        $result = $stmt->execute();

        // Check if the user exists and password matches
        $userFound = false;
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $storedPassword = $row['Password'];
            if ($Password === $storedPassword) {
                // Password matches, log the user in
                $_SESSION['UserID'] = $row['User_ID'];
                $_SESSION['Email'] = $row['Email'];
                $_SESSION['RoleID'] = $row['RoleID'];            
                $_SESSION['FName'] = $row['Fname'];         
                $_SESSION['SName'] = $row['SName'];               
                $_SESSION['PhoneNo'] = $row['PhoneNo'];
                $_SESSION['StreetName'] = $row['StreetName'];
                $_SESSION['HouseNo'] = $row['HouseNo'];
                

                    $RoleQuery = $db -> prepare('SELECT City_Name, NetworkName FROM Assignations WHERE UserID =' . $row['User_ID']);

                    $RoleQueryRes = $RoleQuery ->execute();

                if ($RoleQueryRes) {
                    if ($_SESSION['RoleID'] == '2') {
                        $_SESSION['Network_Name'] = $RoleQueryRes->fetchArray(SQLITE3_ASSOC)['NetworkName']; 
                        debug_to_console($_SESSION['Network_Name']);    
                    } elseif ($row['RoleID'] == '3') {
                        $_SESSION['City_Name'] = $RoleQueryRes->fetchArray(SQLITE3_ASSOC)['City_Name'];
                        debug_to_console($_SESSION['City_Name']); 
                    } else {
                        debug_to_console("Failed to Select Network or City " . $db -> lastErrorMsg());
                        $db->close();
                        exit;
                    }
                }
                
                $userFound = true;
                echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/home.php')</script>";
                exit();
            }
        }

        // If no user is found or the password doesn't match
        if (!$userFound) {
            $message = "Invalid email or password. Please try again.";
            // Redirect back to login 
            echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/home.php?Login=" . urlencode($message) . "')</script>";
            exit();
        }

        $db->close();
    } 



?>
