<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>
    
    <div id="testing">
    
        <div style = "text-align: center">
            <h2>Admin Page:</h2>
        </div>
        
        <div style = "color" class="panel-group">
        
            <div  style = "margin-top: 25px; text-align: center; color: white; width: 45%"class="panel panel-default">
                <div class="panel-heading" style = "text-decoration-line: underline">Create New User:</div>
                <div class="panel-body" style = "color: white;">
                    
                    <form style = "text-align: left; height: 300px" action = "#">
                        <div style = "float : left; flex-direction: column; display: flex">
                            <div style = "float : left; margin-top: 25px">
                                <label for = "Email">Email Address:</label>
                                <input type="text" id = "email"  name = "Email">
                            </div>
                            <div style = "float : left; margin-top: 25px">
                                <label for = "Password">Password:</label>
                                <input type="password" id = "Password"  name = "Password">
                            </div>
                            <div style = "float : left; margin-top: 25px; margin-bottom: 25px">
                                <label for = "ConPass">Confirm Password:</label>
                                <input type="password" id = "ConPass"  name = "ConPass">
                            </div>
                        </div>
                        
                        <div style = "float : right; flex-direction: column; display: flex; height: 295px; position: relative;">
                            <div style = "float : left; margin-top: 10px">
                                <input class = "form-check-input" type = "radio" id = "Network User" value = "Network User">
                                <label class = "form-check-label" for = "Network User">Network User </label> 
                            </div>
                            
                            <div>
                                <input class = "form-check-input" type = "radio" id = "City Council User" value = "City Council User"> 
                                <label class = "form-check-label" for = "City Council User">City Council User </label> 
                            </div> 
                            
                            <div style = "position: absolute; bottom: 0; right: 0">
                                <button class = "btn btn-light"  type = "Submit">Add User</button> 
                            </div>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        
            <!-- Second Panel -->
            <div style = "position: absolute; bottom: 345px; right: 0; height: 325px; margin-top: 25px; text-align: center; color: white; width: 45%; border: 1px solid; border-radius: 16px;" class="panel panel-default">
                <div class="panel-heading" style = "text-decoration-line: underline">Delete User:</div>
                <div class="panel-body"></div>
            </div>

        </div>
        
    </div>
    
</body>
</html>