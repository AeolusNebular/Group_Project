<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/Group_Project/GroupProject_Group12/scripts/Create_User.js"></script>
    <link rel="shortcut icon" href="/Group_Project/GroupProject_Group12/images/favicon.png">
    
    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    
    <?php include("../modules/navbar.php");
    include('../Database_Php_Interactions/Database_Utilities.php'); ?>
    
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
                       
                        <form id = "AdminPanelForm" action = "../Database_Php_Interactions/Create_New_User.php" method ="POST">
                            <div id = "AdminPanelFormContent">
                                <div id = "AdminPanelFormContentInputs">
                                    <label for = "Email">Email Address:</label><br>
                                    <input type="email" id = "Email"  name = "Email" placeholder = "example@email.com">
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
                                <!-- Network and City assignment Code -->
                            <div id = "AdminPanelFormRigth">
                                <div style = "margin-top: 10px">
                                    <input class = "form-check-input" type = "checkbox" id = "Network User" name = "Network_User" onChange="UserType()">
                                    <label class = "form-check-label" for = "Network User">Network User </label> 
                                </div>
                                
                                <div style = "margin-top: 10px">
                                    <input class = "form-check-input" type = "checkbox" id = "City Council User" name = "City_Council_User" onChange="UserType()"> 
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
                                            <?php 
                                                include('../Database_Php_Interactions/CitySelect.php'); 
                                            ?>
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
                                <div id = "AdminPanelAddUserBtn">
                                    <button class = "btn" style = "color: white; margin-bottom: 15px"  type = "Submit" >Add User</button> 
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

            
            <div id = "SummaryContent">Filter by City:
                <form action = "/Group_Project/GroupProject_Group12/Pages/Admin.php" method = "GET" >
                    <select name = "AdminCityFilter" onChange = "this.form.submit()"> 
                        <option value="all">All</option>
                        <?php 
                          include('../Database_Php_Interactions/CitySelect.php'); 
                        ?>
                    </select>
                </form>
            </div>

            <div class="col-12  col-md-12">
                <div class="card" style="height: 90%">
                    <div class="card-header"> City Council Diagram:</div>
                    <div class="card-body">
                        <canvas id = "AdminCityCoucilCanvas"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12  col-md-8">
            
                <div class="card" style="height: 90%">
                    <div class="card-header">Report Details: </div>
                    <div class="card-body">
                        <div style = "float : left">                            
                            <div class="SummaryContent">Filter Options:</div>                                                                             
                        </div>
                        <table>
                            <?php

                                if ($_SERVER['REQUEST_METHOD'] == "GET" && (isset($_GET['AdminCityFilter']))) {
                                    $CityFilter = $_GET['AdminCityFilter'];
                                    $CityFilter = strtoupper($CityFilter);

                                    $filter = array($CityFilter);
                                    $words = array_map('preg_quote', $filter);                               
                                    $regex = '/'.implode('|', $words).'/';
                                    $NoOfCities = array();

                                    foreach ($filter as $x) {
                                        $NoOfCities[$x] = [];
                                    }

                                    $fp = fopen ( "../CSV_Files/coteq_electricity_2013.csv" , "r" );
                                    while (( $data = fgetcsv( $fp )) !== FALSE ) {
                                        list($net_manager,$purchase_area,$street,$zipcode_from,$zipcode_to,$city,$num_connections,$delivery_perc,$perc_of_active_connections,$type_conn_perc,$type_of_connection,$annual_consume,$annual_consume_lowtarif_perc,$smartmeter_perc) = $data;
                                        
                                        if (preg_match($regex, $city)) {                                         
                                            $NoOfCities[$city][] = $data;
                                        }
                                    }
                                    
                                    foreach ($NoOfCities as $city => $DataForCity) {
                                        $AnnualCostForCities = 0;
                                        foreach ($DataForCity as $cities) {
                                            $AnnualCostForCities += $cities[11];
                                        }
                                        echo "$city $AnnualCostForCities ";
                                    } 
                                    fclose ( $fp );
                                }
                               
                                ?>
                            </table>
                    </div>
                </div>
            
            </div>
            
        </div>
    </div>
    
</body>

</html>