<?php
    include('Database_Utilities.php');
    
    function Login() {
        $Email = $_GET['Login_Email'];
        $db = Open_Database();
        
        $result = $db -> query("SELECT Email, Password FROM User_Details, LoginDetails WHERE Email = '" . $Email . "'")
        
        while ($row = $result -> fetcharray(SQLITE3)) {
            $dbEmail = $row[]
        }
    }
?>


