<!DOCTYPE html>
<html lang="en-gb" style="height: 100%; display: grid;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>

    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/login.css">

    <title>Login - Smart Energy Dashboard</title>
</head>

<body id="Login_Body">
    <!-- Modal content -->
    <div class="container-fluid" id="Login_Content">
        <div id="LoginDiv">
            <!-- Form to complete on submit to push to DB -->
            <form method="POST" action="Login.php"> <!-- Ensure form submits to login.php -->
                <div class="mb-4">
                    <h3>Login</h3>
                </div>
                <div class="mb-3">
                    <label for="Login_Email" class="form-label">Email Address: </label>
                    <input type="email" class="form-control" id="Login_Email" name="email" placeholder="Example@gmail.com" required>
                </div>
                <div class="mb-4">
                    <label for="Login_Password" class="form-label">Password: </label>
                    <input type="password" class="form-control" id="Login_Password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary" style="float: right">Login</button>
                </div>
            </form>  
        </div>
    </div>
</body>
</html>



// Database connection
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new SQLite3('Group_Project/GroupProject_Group12/database/users.db');
    $message = "";

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Get user details using email from User_Details and link with LoginDetails
        $query = "SELECT ld.UserID, ld.Password FROM LoginDetails ld " .
                 "JOIN User_Details ud ON ld.UserID = ud.UserID " .
                 "WHERE ud.Email = :email";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();
            $user = $result->fetchArray(SQLITE3_ASSOC);

            if ($user) {
                $storedPassword = $user['Password'];
                if ($password === $storedPassword) {
                    $_SESSION['UserID'] = $user['UserID'];
                    header("Location: home.php");  // Redirect to home.php after successful login
                    exit();
                } else {
                    $message = "Password does not match. Please try again.";
                }
            } else {
                $message = "No account found with that email.";
            }
        } else {
            $message = "Error";
        }
    } else {
        $message = "All fields are required.";
    }

    $conn->close();

    if (!empty($message)) {
        echo "<script>alert('$message');</script>";
    }
}
?>
