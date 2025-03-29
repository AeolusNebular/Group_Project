<!-- 🔒 Revamped Login Modal -->
<div class="modal fade" id="CreateModal" tabindex="-1" aria-labelledby="CreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Centered Modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create User</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- 📝 Login Form -->
            <div class="modal-body">
                <form id="AdminPanelForm" action="../Database_Php_Interactions/Create_New_User.php" method="POST">
                    <div id="AdminPanelFormContent">
                        <div id="AdminPanelFormContentInputs">
                            <label for="Email">Email Address:</label><br>
                            <input type="email" id="Email" name="Email" placeholder="example@email.com">
                        </div>
                        <div id="AdminPanelFormContentInputs">
                            <label for="Password">Password:</label><br>
                            <input type="password" id="Password" name="Password">
                        </div>
                        <div id="AdminPanelFormContentInputs" style="margin-bottom: 25px;">
                            <label for="ConPass">Confirm Password:</label><br>
                            <input type="password" id="ConPass" name="ConPass">
                        </div>
                    </div>
                    <!-- Network and city assignment code -->
                    <div id="AdminPanelFormRight">
                        <div style="margin-top: 10px">
                            <input class="form-check-input" type="checkbox" id="Network_User" name="Network_User" onChange="UserType()">
                            <label class="form-check-label" for="Network_User">Network user</label> 
                        </div>
                        
                        <div style="margin-top: 10px">
                            <input class="form-check-input" type="checkbox" id="City_Council_User" name="City_Council_User" onChange="UserType()"> 
                            <label class="form-check-label" for="City_Council_User">City council user</label> 
                        </div> 
                            <!-- Network and city select statements -->
                        <div id="Network_Select" style="display: none;" class="themed-dropdown">
                            <label for="Networks">Select network:</label> <br>
                            <select class = "form-select" name="Networks" id="Networks">
                                <option value="Coteq"> Coteq </option>
                                <option value="Enduris"> Enduris </option>
                                <option value="Rendo"> Rendo </option>
                                <option value="Westlandia"> Westlandia </option>
                                <option value="Enexis"> Enexis </option>
                                <option value="Stedin"> Stedin </option>
                                <option value="Liander"> Liander </option>
                            </select>
                        </div> 

                        <div id="City_Select" style="display: none;" class="themed-dropdown">
                            <label for="Cities">Select city:</label> <br>
                            <select class="form-select" name="Cities" id="Cities">
                                <?php include("CitySelect.php");?>
                            </select>
                        </div> 

                        <?php 
                            if (isset($_GET['CreateUser'])) {
                                if( $_GET['CreateUser']) {
                                    echo"<div Style = 'color: Green'> Account Successfully Created </div>";
                                } else {
                                    echo"<div Style = 'color: Red'> Account Creation Failed </div>";
                                }
                            }  
                        ?>
                        <div id="AdminPanelAddUserBtn">
                            <button type="submit" class="fancy-button" style="float: right">Add User</button> 
                        </div>
                    </div>
                    
                </form> 
            </div>
        </div>
    </div>
</div>