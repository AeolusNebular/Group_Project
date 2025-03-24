<?php
    //Imports Required Utilities
    require('Database_Utilities.php');
    echo 'Loaded Utilities';
    //Function to Log users Into Application

    if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_POST['Login_Email'])) && (isset($_POST['Login_Password']))) {
            
        // Get user details using email from User_Details and link with LoginDetails
        $Email = trim($_POST['Login_Email']);
        $Password = trim($_POST['Login_Password']);
    
        $db = Open_Database();
        $result = $db -> query("SELECT UserID, Email, Password FROM User_Details, LoginDetails WHERE Email = '" . $Email . "'");
        
        
        while ($row = $result -> fetcharray(SQLITE3_ASSOC)) {
            
            $storedPassword = $row['Password'];
            if ($Password === $storedPassword) {
            
                $_SESSION['UserID'] = $row['UserID'];     
                echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/home.php') </script>";  // Redirect to home.php after successful login
                exit();
            } else {
                $message = "Password does not match. Please try again.";
                echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/home.php?Login=" . $message . "' ) </script>";
            }
        
            $message = "No account found with that email.";
            
        } 
        $db -> close(); 
    }
    

    


?>


