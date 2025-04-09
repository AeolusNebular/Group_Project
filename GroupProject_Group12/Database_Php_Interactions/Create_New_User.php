<?php
    // Import required utilities
    require('Database_Utilities.php');
    
    // If correct method is used aka POST then will write to database
    if (($_SERVER["REQUEST_METHOD"] == "POST")) {
        
        // Grabs variables via the post and saves them into PHP variables
        $Password = $_POST['Password'];
        $ConPassword = $_POST['ConPass'];  
        
        // Opens database connection
        $db = Open_Database();
        
        // Checks if $Password and $ConPassword is set and then checks if they equal each other else debugs to console for now *subject to change*
        if (isset($Password) && isset($ConPassword)) {
            if ($Password === $ConPassword) {
                $Pass = $Password;
            }
        } else {
            debug_to_console('Password Cannot Be Null');
            exit;
        }
        
        // Assigns values of what type of user is created and then sets the variable of the role and the city
        if (isset($_POST['City_Council_User'])) {
            $RoleID = '3';
            $City = $_POST['Cities'];
        } else {
            $City = null;
        }
        
        // Assigns values of what type of user is created and then sets the variable of the role and the network
        if (isset($_POST['Network_User'])) {
            $RoleID = '2';
            $Network = $_POST['Networks'];
        } else {
            $Network = null;
        }
        
        // Begin transaction in order to commit code required for other transactions
        $db->exec('BEGIN TRANSACTION');

        $LoginQuery = $db -> prepare("INSERT INTO LoginDetails( Email, Password) VALUES (:Email, :Password)");
        $LoginQuery -> bindValue(':Email', $_POST['Email']);
        $LoginQuery -> bindValue(':Password', $Pass);
        
        if ($LoginQuery -> execute()){
            debug_to_console('Success Inserted Into Login Details');
        } else {
            debug_to_console('Failed To Insert Into Login' . $db -> lastErrorMsg());
            $Success = false;
            $db->exec('ROLLBACK');
            $db->close();
            exit;
        }
        $db -> exec('COMMIT');

        // Begin Next Transaction
        $db->exec('BEGIN TRANSACTION');

        $LoginIDQuery = $db -> prepare('SELECT LoginID FROM LoginDetails WHERE Email = :Email');
        $LoginIDQuery -> bindValue(':Email', $_POST['Email']);
        $Login_ID_Res = $LoginIDQuery->execute();

        if ($Login_ID_Res) {
            debug_to_console('Successfully Selected LoginID');
            $LoginID = $Login_ID_Res->fetchArray(SQLITE3_ASSOC)['LoginID'];
        }   else {
            debug_to_console("Failed to Select LoginID" . $db -> lastErrorMsg());
            $Success = false;
            $db->close();
            exit;
        }

        // Binds values from query to variables *important as values need to be input in order*
        $query = $db -> prepare("INSERT INTO User_Details( LoginID ,Fname, SName, RoleID, PhoneNo, HouseNo, StreetName, Zipcode, Gender, EC_ID) VALUES ( :LoginID, :Fname, :SName, :RoleID, :PhoneNo, :HouseNo, :StreetName, :Zipcode, :Gender, :EC_ID)");
        $query ->bindValue(':LoginID', $LoginID);
        $query ->bindValue(':Fname', null);
        $query ->bindValue(':SName', null);
        $query ->bindValue(':RoleID', $RoleID);
        $query ->bindValue(':PhoneNo', null);
        $query ->bindValue(':HouseNo', null);
        $query ->bindValue(':StreetName', null);
        $query ->bindValue(':Zipcode', null);
        $query ->bindValue(':Gender', null);
        $query ->bindValue(':EmergencyContact', null);
        
        // ✅ Checks if insert is successful and debugs to console else fails and changes success variable to false and reverts transaction as well as closing and ending connection to DB
        if ($query -> execute()) {
            debug_to_console('Successfully Inserted Into User Details');
        }   else {
            debug_to_console("Failed to Insert New User " . $db -> lastErrorMsg());
            $Success = false;
            $db->exec('ROLLBACK');
            $db->close();
            exit;
        }
        // 🖊️ Commit tranaction *needed for next transaction*
        $db -> exec('COMMIT');
        
        // Begin new transaction
        $db->exec('BEGIN TRANSACTION');

            // Sets up a new query to select user ID to see if one exists already 
            $User_Query = $db-> prepare("SELECT USER_ID FROM User_Details WHERE LoginID = :LoginID");
            $User_Query-> bindValue(':LoginID',$LoginID);
            
            // Executes query and saves to result
            $User_Query_Res = $User_Query->execute();
            
            // If result is true, saves user ID to a variable, else throws error and closes DB
            if ($User_Query_Res) {
                debug_to_console('Successfully Selected UserID');
                $UserID = $User_Query_Res->fetchArray(SQLITE3_ASSOC)['User_ID'];
            }   else {
                debug_to_console("Failed to Select UserID " . $db -> lastErrorMsg());
                $Success = false;
                $db->close();
                exit;
            }
            
            // Sets up new Query  To insert into LoginDetails Table
           /* $sql = $db -> prepare("INSERT INTO LoginDetails(UserID,Password) VALUES (:UserLID,:Password)");
            $sql -> bindValue(':Password', $Pass);
            $sql -> bindValue(':UserLID', $UserID);
            
            // 🚀 Runs Query and if it works Output success and display message, Else State error in console and Execute rollback
            if ($sql -> execute()) {
                debug_to_console('Successfully Inserted Into Login Details');
            }   else {
                debug_to_console("Failed to Insert Login Details " . $db -> lastErrorMsg());
                $Success = false;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }
                */
            //Gets the Network Name From NetworkID
            if ($RoleID == '2') {
                $NetworkIDQuery = $db -> prepare("SELECT NetworkID FROM Network WHERE NetworkName = :Network");
                $NetworkIDQuery-> bindValue(':Network', $Network);

                $Network_Query_Res = $NetworkIDQuery->execute();
                if ($Network_Query_Res) {
                    debug_to_console('Successfully Selected NetworkID');
                    $NetworkID = $Network_Query_Res->fetchArray(SQLITE3_ASSOC)['NetworkID'];
                    $CityID = null;
                }   else {
                    debug_to_console("Failed to Select NetworkID " . $db -> lastErrorMsg());
                    $Success = false;
                    $db->close();
                    exit;
                }
            }  elseif ($RoleID == '3') {

                $CityIDQuery = $db -> prepare("SELECT CityID FROM City WHERE City_Name = :City");
                $CityIDQuery->bindValue(':City',$City);

                $City_Query_Res = $CityIDQuery->execute();
                if ($City_Query_Res) {
                    debug_to_console('Successfully Selected CityID');
                    $CityID = $City_Query_Res->fetchArray(SQLITE3_ASSOC)['CityID'];
                    $NetworkID = null;
                }   else {
                    debug_to_console("Failed to Select CityID " . $db -> lastErrorMsg());
                    $Success = false;
                    $db->close();
                    exit;
                }
            }
            // Final query to insert into assignation table 
            $Ass_Query = $db -> prepare("INSERT INTO Assignations(UserID,CityID,NetworkID) VALUES (:UserAID,:CityID,:NetworkID)");
            $Ass_Query->bindValue(':NetworkID', $NetworkID);
            $Ass_Query->bindValue(':CityID', $CityID);
            $Ass_Query -> bindValue(':UserID', $UserID);
            
            // ✅ Checks if query is successful and debugs to console success, else states error message and rolls back transactions
            if ($Ass_Query -> execute()) {
                debug_to_console('Successfully Inserted Into Ass c:');
                $Success = true;
            }   else {
                debug_to_console("Failed to Insert Into Ass :c" . $db -> lastErrorMsg());
                $Success = false;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }
            
        // 🖊️ Commits last 3 transactions and inserts into database
        $db->exec('COMMIT');
        $db->close();
        
        // 📨 Sends success to page allowing for confirmation proof
        echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/Admin.php?CreateUser=". $Success . "')</script>";
    }
?>