<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>
    
    <!-- Dashboard Content -->
    <div class="container-lg mt-4" id="testing" style="min-height: 700px;">
        <div class="text-center">
            <h2>Admin</h2>
        </div>
        
        <div class="row" >
            <!-- Big chart panel (fat) -->
            <div class="col-12  col-md-5">
                <div class="card" style="height: 90%">
                    <div class="card-header">📊 Create a New User:</div>
                    <div class="card-body" >
                       
                        <form id = "AdminPanelForm" action = "#">
                            <div id = "AdminPanelFormContent">
                                <div id = "AdminPanelFormContentInputs">
                                    <label for = "Email">Email Address:</label><br>
                                    <input type="email" id = "Email"  name = "Email" placeholder = "example@email.com">
                                </div>
                                <div id = "AdminPanelFormContentInputs">
                                    <label for = "Password">Password:</label><br>
                                    <input type="password" id = "Password"  name = "Password"   >
                                </div>
                                <div id = "AdminPanelFormContentInputs" style = "margin-bottom: 25px;">
                                    <label for = "ConPass">Confirm Password:</label><br>
                                    <input type="password" id = "ConPass"  name = "ConPass">
                                </div>
                            </div>
                                <!-- Network and City assignment Code -->
                            <div id = "AdminPanelFormRigth">
                                <div style = "margin-top: 10px">
                                    <input class = "form-check-input" type = "checkbox" id = "Network User" value = "Network User" onChange="UserType()">
                                    <label class = "form-check-label" for = "Network User">Network User </label> 
                                </div>
                                
                                <div style = "margin-top: 10px">
                                    <input class = "form-check-input" type = "checkbox" id = "City Council User" value = "City Council User" onChange="UserType()"> 
                                    <label class = "form-check-label" for = "City Council User">City Council User </label> 
                                </div> 
                                    <!-- Network and City select statements -->
                                <div id = "Network_Select"  style = "margin-top: 10px; display: none;">
                                    <label for="Networks">Which Network Is The User In:</label> <br>
                                    <select class = "form-select" name="Networks" id="Networks">
                                        <option value = "Coteq"> Coteq </option>
                                        <option value = "Enduris"> Enduris </option>
                                        <option value = "Rendo"> Rendo </option>
                                        <option value = "Westlandia"> Westlandia </option>
                                        <option value = "Enexis"> Enexis </option>
                                        <option value = "Stedin"> Stedin </option>
                                        <option value = "Liander"> Liander </option>
                                    </select>
                                </div> 

                                <div id = "City_Select"  style = "margin-top: 10px; display: none;">
                                    <label for="Cities">Which City Is The User In: </label> <br>
                                    <select class = "form-select" name="Cities" id="Cities">
                                        <option value = "Coteq"> Coteq </option>
                                        <option value = "Enduris"> Enduris </option>
                                        <option value = "Rendo"> Rendo </option>
                                        <option value = "Westlandia"> Westlandia </option>
                                        <option value = "Enexis"> Enexis </option>
                                        <option value = "Stedin"> Stedin </option>
                                        <option value = "Liander"> Liander </option>
                                    </select>
                                </div> 
                                
                                <div id = "AdminPanelAddUserBtn">
                                    <button class = "btn btn-light"  type = "Submit" onClick = "Create_New_User()">Add User</button> 
                                </div>
                            </div>
                            
                        </form>  
                    </div>
                </div>
            </div>

            <div class="col-12  col-md-7">
                <div class="card" style="height: 90%">
                    <div class="card-header">📊 Network Users</div>
                    <div class="card-body" >
                        <canvas id = "NetworkCanvas" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</body>

</html>