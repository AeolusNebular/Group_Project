<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Scripts -->
    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>

    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>
    
    <!-- Dashboard Content -->
    <div class="container mt-4" id="testing">
        <div class="text-center">
            <h2>Admin</h2>
        </div>
        
        <div class="row">
            <!-- Big chart panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">📊 Energy Chart</div>
                    <div class="card-body" style="height:350px;">
                        <canvas id="testChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Two even cards -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Create New User</div>
                    <div class="card-body">
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
            </div>
            
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Delete User</div>
                    <div class="card-body">
                        <ul>
                            <li>When the imposter is sus:</li>
                            <li>Dun, dun dun dun dun dun dun dun, du-du-dun.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>