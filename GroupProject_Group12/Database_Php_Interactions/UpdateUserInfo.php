<?php
    require('Database_Utilities.php');
    session_start();
    debug_to_console($_SESSION['UserID']);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['UserID'])) {
        $db = Open_Database();
        $FName = isset($_POST['UserFName']) ? $_POST['UserFName'] : ' ';
        $SName = isset($_POST['UserLName']) ? $_POST['UserLName'] : ' ';
        $PhoneNo = isset($_POST['UserPhoneNo']) ? $_POST['UserPhoneNo'] : ' ';
        $HouseNo = isset($_POST['UserHomeNo']) ? $_POST['UserHomeNo'] : ' ';

        $Sql_UserQuery = $db -> prepare("UPDATE User_Details SET FName = ' $FName  ', SName = ' $SName ', PhoneNo = ' $PhoneNo ' , HouseNo = '  $HouseNo ' WHERE User_ID == ". $_SESSION['UserID'] );
       
        
        if ($Sql_UserQuery -> execute()) { 
            debug_to_console('Successfully Inserted Into User Details');
            $Success = true;
        }   else {
            debug_to_console("Failed to Insert New User " . $db -> lastErrorMsg());
            $Success = false;
            $db->close();
            exit;
        }

        $_SESSION['FName'] = $_POST['UserFName'];
        $_SESSION['LName'] = $_POST['UserLName'];
        $_SESSION['PhoneNo'] = $_POST['UserPhoneNo'];
        $_SESSION['HouseNo'] = $_POST['UserHomeNo'];

        echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/account.php?UpdateUser=". $Success . "') </script>";
    }
    ?>