<!DOCTYPE html>
<html lang="en" style = "height: 100%; display: grid;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/Loginstyle.css">

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/Login_Modal.js"></script>

    <title>Login Page</title>
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