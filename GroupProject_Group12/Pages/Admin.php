<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>

    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>
    
    <div id="testing">
    
        <div id = "AdminHeading">
            <h2>Admin Page:</h2>
        </div>
        
        <div class="panel-group">
        
            <div  id = "AdminPanel" class="panel panel-default">
                <div class="panel-heading" id = "AdminPanelHeading">Create New User:</div>
                <div class="panel-body" id = "AdminPanelBody">
                    
                    <form id = "AdminPanelForm" action = "#">
                        <div id = "AdminPanelFormContent">
                            <div id = "AdminPanelFormContentInputs">
                                <label for = "Email">Email Address:</label>
                                <input type="text" id = "email"  name = "Email">
                            </div>
                            <div id = "AdminPanelFormContentInputs">
                                <label for = "Password">Password:</label>
                                <input type="password" id = "Password"  name = "Password">
                            </div>
                            <div id = "AdminPanelFormContentInputs" style = "margin-bottom: 25px;">
                                <label for = "ConPass">Confirm Password:</label>
                                <input type="password" id = "ConPass"  name = "ConPass">
                            </div>
                        </div>
                        
                        <div id = "AdminPanelFormRigth">
                            <div style = "margin-top: 10px">
                                <input class = "form-check-input" type = "radio" id = "Network User" value = "Network User">
                                <label class = "form-check-label" for = "Network User">Network User </label> 
                            </div>
                            
                            <div>
                                <input class = "form-check-input" type = "radio" id = "City Council User" value = "City Council User"> 
                                <label class = "form-check-label" for = "City Council User">City Council User </label> 
                            </div> 
                            
                            <div id = "AdminPanelAddUserBtn">
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