<!-- 🔒 Revamped Login Modal -->
<div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Login</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- 📝 Login Form -->
            <div class="modal-body">
                <form action="index.php" method="POST"> 
                    <div class="mb-3">
                        <label for="Login_Email" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="Login_Email" name="Login_Email" placeholder="Example@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="Login_Password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="Login_Password" name="Login_Password" placeholder="Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="fancy-button">Login</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>

// Database connection
<?php


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
                    header("Location: Group_Project/GroupProject_Group12/Pages/home.php");  // Redirect to home.php after successful login
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