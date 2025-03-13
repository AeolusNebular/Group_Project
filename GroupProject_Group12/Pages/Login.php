<!DOCTYPE html>
<html lang="en-gb" style = "height: 100%; display: grid;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>

    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/login.css">

    <title>Login - Smart Energy Dashboard</title>
</head>

<body id = "Login_Body">
    
    <!-- Modal content -->
    <div class = "container-fluid" id = "Login_Content">
        <div id = "LoginDiv">
            <!--Form to complete on submit to push to Db -->
            <form> 
                <div class="mb-4">
                    <h3>Login</h3>
                </div>
                <div class = "mb-3">
                    <label for = "Login_Email" class="form-label">Email Address: </label>
                    <input type="email" class="form-control" id = "Login_Email" placeholder = "Example@gmail.com">
                </div>
                <div class = "mb-4">
                    <label For = "Login_Password"class="form-label">Password: </label>
                    <input type="password" class="form-control" id = "Login_Password"  placeholder = "Password" >
                </div>
                <div class = "mb-4">
                    <button class="btn btn-primary" style = "float: right" onClick= "Login_User()" >Login</button>
                </div>
            </form>  
        </div>
    </div>

</body>
</html>