<!DOCTYPE html>
<html lang="en-gb" style = "height: 100%; display: grid;">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>

    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/login.css">
    
    <title>Login - Smart Energy Dashboard</title>
</head>

<body id = "Login_Body">
    
    <?php include('../Database_Php_Interactions/Database_Utilities.php'); ?>
    
    <!-- Modal content -->
    <div class = "container-fluid" id = "Login_Content">
        <div id = "LoginDiv">
            <!--Form to complete on submit to push to Db -->
            <form action = "../database php Interactions/Login_Php_Code.php" onSubmit= "GET"> 
                <div class="mb-4">
                    <h3>Login</h3>
                </div>
                <div class = "mb-3">
                    <label for = "Login_Email" class="form-label">Email Address: </label>
                    <input type="email" class="form-control" name = "Login_Email" placeholder = "Example@gmail.com">
                </div>
                <div class = "mb-4">
                    <label For = "Login_Password"class="form-label">Password: </label>
                    <input type="password" class="form-control" name = "Login_Password"  placeholder = "Password" >
                </div>
                <div class = "mb-4">
                    <button class="btn btn-primary" style = "float: right" onClick= "" >Login</button>
                </div>
            </form>  
        </div>
    </div>

</body>
</html>