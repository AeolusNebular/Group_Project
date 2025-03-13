<!DOCTYPE html>
<html lang="en-gb" style = "height: 100%; display: grid;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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