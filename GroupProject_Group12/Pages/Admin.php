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
    

        <div class="row">
            <!-- Big chart panel (fat) -->
            <div class="col-12  col-md-4">
                <div class="card" style="height:370px;">
                    <div class="card-header">📊 Create a New User:</div>
                    <div class="card-body" >
                       
                        <form id = "AdminPanelForm" action = "#">
                            <div id = "AdminPanelFormContent">
                                <div id = "AdminPanelFormContentInputs">
                                    <label for = "Email">Email Address:</label><br>
                                    <input type="text" id = "email"  name = "Email">
                                </div>
                                <div id = "AdminPanelFormContentInputs">
                                    <label for = "Password">Password:</label><br>
                                    <input type="password" id = "Password"  name = "Password">
                                </div>
                                <div id = "AdminPanelFormContentInputs" style = "margin-bottom: 25px;">
                                    <label for = "ConPass">Confirm Password:</label><br>
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
            </div>

        </div>
        
    </div>
<script>
    document.getElementByID    
</script>
</body>





</html>