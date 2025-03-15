<?php 
    include('Database_Utilities.php');



    if (($_SERVER["REQUEST_METHOD"] == "POST")) {

        $Password = $_POST['Password'];
        $ConPassword = $_POST['ConPass'];
       
        

        $db = Open_Database(); 

        if ($Password === $ConPassword) {
            $Pass = $Password;
        }

        if (isset($_POST['City_Council_User'])) {
            $RoleID = '3';
            $City = $_POST['Cities'];           
        } else {
            $City = null;
        }

        if (isset($_POST['Network_User'])) {
            $RoleID = '2';
            $Network = $_POST['Networks'];
        } else {
            $Network = null;
        }

        $db->exec('BEGIN TRANSACTION');
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

            if ($query -> execute()) {
                debug_to_console('Successfully Inserted Into User Details');
            }   else {
                debug_to_console("Failed to Insert New User " . $db -> lastErrorMsg());
                $Success = false;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }
            
        $db -> exec('COMMIT');


        $db->exec('BEGIN TRANSACTION');

            $User_Query = $db-> prepare("SELECT USER_ID FROM User_Details WHERE Email = :Email");
            $User_Query-> bindValue(':Email',$_POST['Email']);

            $User_Query_Res = $User_Query->execute();

            if ($User_Query_Res) {
                debug_to_console('Successfully Selected UserID');
                $UserID = $User_Query_Res->fetchArray(SQLITE3_ASSOC)['User_ID'];
            }   else {
                debug_to_console("Failed to Select UserID " . $db -> lastErrorMsg());
                $Success = false;
                $db->close();
                exit;
            }    
            
            $sql = $db -> prepare("INSERT INTO LoginDetails(UserID,Password) VALUES (:UserLID,:Password)");
            $sql -> bindValue(':Password', $Pass);
            $sql -> bindValue(':UserLID', $UserID);
            
            if ($sql -> execute()) {
                debug_to_console('Successfully Inserted Into Login Details');
            }   else {
                debug_to_console("Failed to Insert Login Details " . $db -> lastErrorMsg());
                $Success = true;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }

            $Ass_Query = $db -> prepare("INSERT INTO Assignations(UserID,NetworkName,City_Name) VALUES (:UserAID,:NetworkName,:CityName)");
            $Ass_Query->bindValue(':NetworkName', $Network);
            $Ass_Query->bindValue(':CityName', $City);
            $Ass_Query -> bindValue(':UserAID', $UserID);

            if ($Ass_Query -> execute()) {
                debug_to_console('Successfully Inserted Into Ass c:');
                $Success = true;
            }   else {
                debug_to_console("Failed to Insert Into Ass :c" . $db -> lastErrorMsg());
                $Success = true;
                $db->exec('ROLLBACK');
                $db->close();
                exit;
            }

        $db->exec('COMMIT');
        
        $db->close();

        echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/Admin.php?CreateUser=". $Success . "') </script>";
    }
?>
