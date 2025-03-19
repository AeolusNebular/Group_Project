<?php
    //Imports required utilities
    require('Database_Utilities.php');
    // if correct method is Used aka POST then will Write to DB 
    if (($_SERVER["REQUEST_METHOD"] == "POST")) {

        //Grabs variables via the post and saves them into PHP variables
        $Password = $_POST['Password'];
        $ConPassword = $_POST['ConPass'];  
        
        //Opens DB Connection
        $db = Open_Database(); 

        //Checks if $Password and $ConPassword is set and then checks if they equal each other else Debugs to console for now *Subject to change*
        if (isset($Password) && isset($ConPassword)) {
            if ($Password === $ConPassword) {
                $Pass = $Password;
            }
        } else {
            debug_to_console('Password Cannot Be Null');
            exit;
        }

        //Assigns Values of what type of User is created and then sets the variable of the Role and the City
        if (isset($_POST['City_Council_User'])) {
            $RoleID = '3';
            $City = $_POST['Cities'];           
        } else {
            $City = null;
        }

         //Assigns Values of what type of User is created and then sets the variable of the Role and the Network
        if (isset($_POST['Network_User'])) {
            $RoleID = '2';
            $Network = $_POST['Networks'];
        } else {
            $Network = null;
        }


        //Begin a Transaction so that i can commit all code that is required for other transactions 
        $db->exec('BEGIN TRANSACTION');

            //Binds values from query to Variables *Sorta required as Values need to be input in order*
            $query = $db -> prepare("INSERT INTO User_Details( Fname, SName, RoleID, Email, PhoneNo, HouseNo, StreetName, Zipcode, Gender, EmergencyContact) VALUES ( :Fname, :SName, :RoleID, :Email, :PhoneNo, :HouseNo, :StreetName, :Zipcode, :Gender, :EmergencyContact)");
            $query ->bindValue(':Fname', ' ');
            $query ->bindValue(':SName', ' ');
            $query ->bindValue(':RoleID', $RoleID);
            $query ->bindValue(':Email', $_POST['Email']);
            $query ->bindValue(':PhoneNo', null);
            $query ->bindValue(':HouseNo', ' ');
            $query ->bindValue(':StreetName', ' ');
            $query ->bindValue(':Zipcode', ' ');
            $query ->bindValue(':Gender', ' ');
            $query ->bindValue(':EmergencyContact', ' ');


            //Checks if Insert is successful and debugs to console else Fails and changes Success variable to false and Reverts transaction as well as closing and ending connection to DB
            if ($query -> execute()) {
                debug_to_console('Successfully Inserted Into User Details');
            }   else {
                debug_to_console("Failed to Insert New User " . $db -> lastErrorMsg());
                $Success = false;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }
            //Commits Tranaction *Needed for next Transaction*   
        $db -> exec('COMMIT');


        //Begins a New Transaction
        $db->exec('BEGIN TRANSACTION');
            //Sets up a new Query to select user ID to see if one exists already 
            $User_Query = $db-> prepare("SELECT USER_ID FROM User_Details WHERE Email = :Email");
            $User_Query-> bindValue(':Email',$_POST['Email']);

            //Executes Query and saves to a Result
            $User_Query_Res = $User_Query->execute();

            //If result is True Saves UserID to a variable, Else Throws an error and closes DB
            if ($User_Query_Res) {
                debug_to_console('Successfully Selected UserID');
                $UserID = $User_Query_Res->fetchArray(SQLITE3_ASSOC)['User_ID'];
            }   else {
                debug_to_console("Failed to Select UserID " . $db -> lastErrorMsg());
                $Success = false;
                $db->close();
                exit;
            }    
            

            //Sets up new Query  To insert into LoginDetails Table
            $sql = $db -> prepare("INSERT INTO LoginDetails(UserID,Password) VALUES (:UserLID,:Password)");
            $sql -> bindValue(':Password', $Pass);
            $sql -> bindValue(':UserLID', $UserID);
            
            //Runs Query and if it works Output success and display message, Else State error in console and Execute rollback
            if ($sql -> execute()) {
                debug_to_console('Successfully Inserted Into Login Details');
            }   else {
                debug_to_console("Failed to Insert Login Details " . $db -> lastErrorMsg());
                $Success = false;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }
            
            //Final Query to insert into Assignation Table 
            $Ass_Query = $db -> prepare("INSERT INTO Assignations(UserID,NetworkName,City_Name) VALUES (:UserAID,:NetworkName,:CityName)");
            $Ass_Query->bindValue(':NetworkName', $Network);
            $Ass_Query->bindValue(':CityName', $City);
            $Ass_Query -> bindValue(':UserAID', $UserID);

            //Checks if Query is successful and debugs to console success, else States error message and rolls back transactions
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
        //Commits Last 3 transactions and Inserts them into Database
        $db->exec('COMMIT');
        $db->close();
        
        //Sends Success to the Page to allow for confirmation Proof
        echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/Admin.php?CreateUser=". $Success . "') </script>";
    }
?>
