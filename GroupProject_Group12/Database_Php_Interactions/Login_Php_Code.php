<?php
session_start();


require('Database_Utilities.php');
echo 'Loaded Utilities';


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Login_Email']) && isset($_POST['Login_Password'])) {
    // Get user details using email from User_Details and link with LoginDetails
    $Email = trim($_POST['Login_Email']);
    $Password = trim($_POST['Login_Password']);

$query = "select User_ID, Password FROM User_Details, LoginDetails WHERE Email = '".$Email."'";
    $db = Open_Database();
    $stmt = $db->prepare($query);
    $stmt->bindValue(':email', $Email, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Check if the user exists and password matches
    $userFound = false;
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $storedPassword = $row['Password'];
        if ($Password === $storedPassword) {
            // Password matches, log the user in
            $_SESSION['UserID'] = $row['User_ID'];
            $_SESSION['Email'] = $row['Email']; 
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
