<?php
    //Imports Required Utilities
    require('Database_Utilities.php');
   
    //Function to Log users Into Application
    function Login() {

        if ($_SERVER['REQUEST_METHOD'] == "GET" && (isset($_POST['Login_Email'])) && (isset($_POST['Password']))) {
            $Email = $_GET['Login_Email'];
            $db = Open_Database();
            
            $result = $db -> query("SELECT Email, Password FROM User_Details, LoginDetails WHERE Email = '" . $Email . "'");
            
            while ($row = $result -> fetcharray(SQLITE3)) {
                $dbEmail = $row['Email'];
            }
        }
    }
?>


