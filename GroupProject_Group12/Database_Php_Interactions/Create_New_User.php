<?php
    // Import required utilities
    require('Database_Utilities.php');
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require ('../PHPMailer/src/Exception.php');
    require ('../PHPMailer/src/PHPMailer.php');
    require ('../PHPMailer/src/SMTP.php');
    
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
        
        // Begin a transaction in order to commit code required for other transactions 
        $db->exec('BEGIN TRANSACTION');
        
        // Binds values from query to variables *important as values need to be input in order*
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
        
        // Checks if insert is successful and debugs to console else fails and changes success variable to false and reverts transaction as well as closing and ending connection to DB
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
            $User_Query = $db-> prepare("SELECT USER_ID FROM User_Details WHERE Email = :Email");
            $User_Query-> bindValue(':Email',$_POST['Email']);
            
            // Executes query and saves to a Result
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
            $sql = $db -> prepare("INSERT INTO LoginDetails(UserID,Password) VALUES (:UserLID,:Password)");
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
            
            // Final query to insert into assignation table 
            $Ass_Query = $db -> prepare("INSERT INTO Assignations(UserID,NetworkName,City_Name) VALUES (:UserAID,:NetworkName,:CityName)");
            $Ass_Query->bindValue(':NetworkName', $Network);
            $Ass_Query->bindValue(':CityName', $City);
            $Ass_Query -> bindValue(':UserAID', $UserID);
            
            // Checks if query is successful and debugs to console success, else states error message and rolls back transactions
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
            
            if ($Success) {
                $mail = new PHPMailer(true);
                
                try {
                    // ⚙️ Server settings
                    $mail->isSMTP();                                        // 📨 Send using SMTP
                    $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                 // Enable verbose debug output
                    $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                               // Enable SMTP authentication
                    $mail->Username   = 'smartenergydashboard@gmail.com';   // SMTP username
                    $mail->Password   = 'kugg mtgw lvbi fgpq';              // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Enable implicit TLS encryption
                    $mail->Port       = 465;                       
                    $mail->setFrom('smartenergydashboard@gmail.com', 'Smart Energy Dashboard');
                    $mail->addAddress($_GET['Email']);                      // Name is optional
                    
                    $mail->isHTML(true);                                    // Set email format to HTML
                    $mail->Subject = 'New Account Creation Notification';
                    $mail->Body    = 'An Account has been made for you';
                    
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            
        // 🖊️ Commits last 3 transactions and inserts into database
        $db->exec('COMMIT');
        $db->close();
        
        // 📨 Sends success to page allowing for confirmation proof
        echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/Admin.php?CreateUser=". $Success . "') </script>";
    }
?>
